<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\StoreLoanRequest;
use App\Http\Requests\Siswa\StoreReturnRequest;
use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $items = Peminjaman::query()
            ->with(['book', 'pengembalian'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if (! $request->expectsJson()) {
            $books = Book::query()->where('stok_tersedia', '>', 0)->orderBy('judul')->get();

            return view('siswa.loans.index', compact('items', 'books'));
        }

        return response()->json($items);
    }

    public function store(StoreLoanRequest $request): JsonResponse|RedirectResponse
    {
        $activeLoans = Peminjaman::query()
            ->where('user_id', $request->user()->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($activeLoans >= 3) {
            if (! $request->expectsJson()) {
                return back()->withErrors(['loan' => 'Maksimal 3 buku aktif dipinjam.']);
            }

            return response()->json([
                'message' => 'Maksimal 3 buku aktif dipinjam.',
            ], 422);
        }

        $loan = DB::transaction(function () use ($request): Peminjaman {
            $book = Book::whereKey($request->integer('book_id'))->lockForUpdate()->firstOrFail();

            if ($book->stok_tersedia < 1) {
                abort(422, 'Stok buku habis.');
            }

            $book->decrement('stok_tersedia');

            return Peminjaman::create([
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_jatuh_tempo' => now()->addDays($request->integer('durasi_hari'))->toDateString(),
                'status' => 'dipinjam',
                'catatan' => $request->input('catatan'),
            ]);
        });

        if (! $request->expectsJson()) {
            return redirect()->route('siswa.loans.index')->with('success', 'Peminjaman berhasil diajukan.');
        }

        return response()->json([
            'message' => 'Peminjaman berhasil diajukan.',
            'data' => $loan,
        ], 201);
    }

    public function returnBook(StoreReturnRequest $request, Peminjaman $peminjaman): JsonResponse|RedirectResponse
    {
        if ($peminjaman->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak boleh mengakses transaksi ini.');
        }

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
            return redirect()->route('siswa.loans.index')->with('success', 'Pengembalian berhasil diajukan.');
        }

        return response()->json([
            'message' => 'Pengembalian berhasil diajukan.',
        ]);
    }
}
