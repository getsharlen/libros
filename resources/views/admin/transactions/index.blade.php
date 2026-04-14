@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <h2 class="font-display text-3xl font-bold">Transaksi Peminjaman</h2>

        <div class="grid gap-4 lg:grid-cols-2">
            <article class="panel p-5">
                <h3 class="font-display text-xl font-semibold">Catat Peminjaman</h3>
                <form method="POST" action="{{ route('admin.transactions.loan') }}" class="mt-4 grid gap-3">
                    @csrf
                    <label class="field">
                        <span>Anggota</span>
                        <select name="user_id" required>
                            <option value="">Pilih Anggota</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->nis }})</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Buku</span>
                        <select name="book_id" required>
                            <option value="">Pilih Buku</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">{{ $book->judul }} - Stok {{ $book->stok_tersedia }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="field">
                        <span>Durasi (hari)</span>
                        <input type="number" name="durasi_hari" min="1" max="14" value="7" required>
                    </label>
                    <button class="btn-primary" type="submit">Simpan Transaksi</button>
                </form>
            </article>

            <article class="panel p-5">
                <h3 class="font-display text-xl font-semibold">Filter Status</h3>
                <form method="GET" class="mt-4 flex items-end gap-3">
                    <label class="field flex-1">
                        <span>Status</span>
                        <select name="status">
                            <option value="">Semua</option>
                            <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                            <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
                            <option value="terlambat" @selected(request('status') === 'terlambat')>Terlambat</option>
                        </select>
                    </label>
                    <button class="chip" type="submit">Terapkan</button>
                </form>
            </article>
        </div>

        <div class="panel overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_jatuh_tempo }}</td>
                            <td>{{ strtoupper($loan->status) }}</td>
                            <td>
                                @if ($loan->status === 'dipinjam')
                                    <form method="POST" action="{{ route('admin.transactions.return', $loan) }}" class="grid gap-2">
                                        @csrf
                                        <input class="input-min" type="date" name="tanggal_kembali">
                                        <input class="input-min" type="number" name="denda" min="0" step="1000" placeholder="Denda opsional">
                                        <button type="submit" class="btn-primary">Konfirmasi Kembali</button>
                                    </form>
                                @else
                                    <span class="text-slate-300">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-300">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $items->links() }}
    </section>
@endsection
