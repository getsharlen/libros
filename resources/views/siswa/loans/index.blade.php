@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <h2 class="font-display text-3xl font-bold text-slate-900">Peminjaman Saya</h2>

        <form method="GET" class="panel p-4">
            <label class="field">
                <span>Cari Judul</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Masukkan judul buku">
            </label>
        </form>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($books->take(4) as $book)
                <article class="panel p-4 reveal">
                    <img
                        src="https://picsum.photos/seed/{{ urlencode($book->kode_buku.'-'.$book->judul) }}/220/300"
                        alt="Cover buku {{ $book->judul }}"
                        class="h-36 w-full rounded-xl border border-orange-200 object-cover"
                        loading="lazy"
                    >
                    <h3 class="mt-3 line-clamp-2 text-sm font-bold text-slate-900">{{ $book->judul }}</h3>
                    <p class="text-xs text-slate-500">{{ $book->penulis }}</p>
                    <p class="mt-1 text-xs font-semibold text-orange-700">Stok tersisa: {{ $book->stok_tersedia }}</p>
                </article>
            @empty
                <article class="panel p-4 text-sm text-slate-500">Belum ada buku tersedia untuk dipinjam.</article>
            @endforelse
        </div>

        <article class="panel p-5">
            <h3 class="font-display text-xl font-semibold text-slate-900">Ajukan Peminjaman</h3>
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
                        <th>Cover</th>
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
                            <td>
                                <img
                                    src="https://picsum.photos/seed/{{ urlencode($loan->book->kode_buku.'-'.$loan->book->judul) }}/120/170"
                                    alt="Cover buku {{ $loan->book->judul }}"
                                    class="book-cover"
                                    loading="lazy"
                                >
                            </td>
                            <td>
                                <p class="font-semibold text-slate-800">{{ $loan->book->judul }}</p>
                                <p class="text-xs text-slate-500">{{ $loan->book->penulis }}</p>
                            </td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_jatuh_tempo }}</td>
                            <td>
                                <span class="chip">{{ strtoupper($loan->status) }}</span>
                            </td>
                            <td>
                                @if ($loan->status === 'dipinjam')
                                    <form method="POST" action="{{ route('siswa.loans.return', $loan) }}" class="grid gap-2">
                                        @csrf
                                        <input class="input-min" type="date" name="tanggal_kembali">
                                        <button type="submit" class="btn-primary">Ajukan Kembali</button>
                                    </form>
                                @else
                                    <span class="text-slate-500">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-500">Belum ada peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $items->links() }}
    </section>
@endsection
