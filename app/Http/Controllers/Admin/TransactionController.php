<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\StoreReturnRequest;
use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $query = Peminjaman::query()->with(['user', 'book', 'pengembalian'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $items = $query->paginate(10)->withQueryString();

        if (! $request->expectsJson()) {
            $members = \App\Models\User::query()->where('role', 'siswa')->orderBy('name')->get(['id', 'name', 'nis']);
            $books = Book::query()->orderBy('judul')->get(['id', 'judul', 'kode_buku', 'stok_tersedia']);

            return view('admin.transactions.index', compact('items', 'members', 'books'));
        }

        return response()->json($items);
    }

    public function storeLoan(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:14'],
            'catatan' => ['nullable', 'string'],
        ]);

        $loan = DB::transaction(function () use ($data): Peminjaman {
            $book = Book::whereKey($data['book_id'])->lockForUpdate()->firstOrFail();

            if ($book->stok_tersedia < 1) {
                abort(422, 'Stok buku habis.');
            }

            $book->decrement('stok_tersedia');

            return Peminjaman::create([
                'user_id' => $data['user_id'],
                'book_id' => $book->id,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_jatuh_tempo' => now()->addDays((int) $data['durasi_hari'])->toDateString(),
                'status' => 'dipinjam',
                'catatan' => $data['catatan'] ?? null,
            ]);
        });

        if (! $request->expectsJson()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Transaksi peminjaman berhasil dicatat.');
        }

        return response()->json([
            'message' => 'Transaksi peminjaman berhasil dicatat.',
            'data' => $loan,
        ], 201);
    }

    public function approve(Request $request, Peminjaman $peminjaman): JsonResponse|RedirectResponse
    {
        if ($peminjaman->status !== 'menunggu') {
            if (! $request->expectsJson()) {
                return back()->withErrors(['loan' => 'Peminjaman tidak dapat disetujui.']);
            }

            return response()->json(['message' => 'Peminjaman tidak dapat disetujui.'], 422);
        }

        DB::transaction(function () use ($peminjaman): void {
            $book = Book::whereKey($peminjaman->book_id)->lockForUpdate()->firstOrFail();

            if ($book->stok_tersedia < 1) {
                abort(422, 'Stok buku habis.');
            }

            $book->decrement('stok_tersedia');
            $peminjaman->update(['status' => 'dipinjam']);
        });

        if (! $request->expectsJson()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Peminjaman disetujui dan stok diperbarui.');
        }

        return response()->json(['message' => 'Peminjaman disetujui.']);
    }

    public function reject(Request $request, Peminjaman $peminjaman): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'alasan' => ['required', 'string', 'max:1000'],
        ]);

        if ($peminjaman->status !== 'menunggu') {
            if (! $request->expectsJson()) {
                return back()->withErrors(['loan' => 'Peminjaman tidak dapat ditolak.']);
            }

            return response()->json(['message' => 'Peminjaman tidak dapat ditolak.'], 422);
        }

        $peminjaman->update(['status' => 'ditolak', 'alasan_penolakan' => $data['alasan']]);

        if (! $request->expectsJson()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Peminjaman ditolak.');
        }

        return response()->json(['message' => 'Peminjaman ditolak.']);
    }

    public function confirmReturn(StoreReturnRequest $request, Peminjaman $peminjaman): JsonResponse|RedirectResponse
    {
        if ($peminjaman->status !== 'dipinjam') {
            if (! $request->expectsJson()) {
                return back()->withErrors(['loan' => 'Peminjaman ini sudah diproses pengembaliannya.']);
            }

            return response()->json([
                'message' => 'Peminjaman ini sudah diproses pengembaliannya.',
            ], 422);
        }

        DB::transaction(function () use ($request, $peminjaman): void {
            $book = Book::whereKey($peminjaman->book_id)->lockForUpdate()->firstOrFail();
            $tanggalKembali = $request->date('tanggal_kembali')?->toDateString() ?? now()->toDateString();
            $kembali = \Carbon\Carbon::parse($tanggalKembali);
            $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
            $hariTerlambat = $kembali->greaterThan($jatuhTempo) ? $jatuhTempo->diffInDays($kembali) : 0;
            $dendaOtomatis = $hariTerlambat * 1000;

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'processed_by' => $request->user()->id,
                'tanggal_kembali' => $tanggalKembali,
                'denda' => $request->has('denda') ? $request->input('denda') : $dendaOtomatis,
                'catatan_kondisi' => $request->input('catatan_kondisi'),
            ]);

            $status = $hariTerlambat > 0 ? 'terlambat' : 'dikembalikan';

            $peminjaman->update(['status' => $status]);
            $book->increment('stok_tersedia');
        });

        if (! $request->expectsJson()) {
            return redirect()->route('admin.transactions.index')->with('success', 'Pengembalian berhasil diproses.');
        }

        return response()->json([
            'message' => 'Pengembalian berhasil diproses.',
        ]);
    }
}
