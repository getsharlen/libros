@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <h2 class="font-display text-3xl font-bold">Peminjaman Saya</h2>

        <article class="panel p-5">
            <h3 class="font-display text-xl font-semibold">Ajukan Peminjaman</h3>
            <form method="POST" action="{{ route('siswa.loans.store') }}" class="mt-4 grid gap-3 md:grid-cols-3">
                @csrf
                <label class="field md:col-span-2">
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
                <label class="field md:col-span-3">
                    <span>Catatan</span>
                    <input type="text" name="catatan" placeholder="Opsional">
                </label>
                <div class="md:col-span-3">
                    <button class="btn-primary" type="submit">Ajukan Peminjaman</button>
                </div>
            </form>
        </article>

        <div class="panel overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $loan)
                        <tr>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_jatuh_tempo }}</td>
                            <td>{{ strtoupper($loan->status) }}</td>
                            <td>
                                @if ($loan->status === 'dipinjam')
                                    <form method="POST" action="{{ route('siswa.loans.return', $loan) }}" class="grid gap-2">
                                        @csrf
                                        <input class="input-min" type="date" name="tanggal_kembali">
                                        <button type="submit" class="btn-primary">Ajukan Kembali</button>
                                    </form>
                                @else
                                    <span class="text-slate-300">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-slate-300">Belum ada peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $items->links() }}
    </section>
@endsection
