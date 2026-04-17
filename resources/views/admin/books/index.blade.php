@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-display text-3xl font-bold text-slate-900">Manajemen Buku</h2>
            <a href="{{ route('admin.books.create') }}" class="btn-primary">Tambah Buku</a>
        </div>

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
                        class="h-40 w-full rounded-xl border border-orange-200 object-cover"
                        loading="lazy"
                    >
                    <h3 class="mt-3 line-clamp-2 text-sm font-bold text-slate-900">{{ $book->judul }}</h3>
                    <p class="text-xs text-slate-500">{{ $book->penulis }}</p>
                    <p class="mt-2 text-xs font-semibold text-orange-700">Stok {{ $book->stok_tersedia }} dari {{ $book->stok_total }}</p>
                </article>
            @empty
                <article class="panel p-4 text-sm text-slate-500">Belum ada data buku untuk ditampilkan.</article>
            @endforelse
        </div>

        <div class="panel overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>
                                <img
                                    src="https://picsum.photos/seed/{{ urlencode($book->kode_buku.'-'.$book->judul) }}/120/170"
                                    alt="Cover buku {{ $book->judul }}"
                                    class="book-cover"
                                    loading="lazy"
                                >
                            </td>
                            <td>{{ $book->kode_buku }}</td>
                            <td>
                                <p class="font-semibold text-slate-800">{{ $book->judul }}</p>
                                <p class="text-xs text-slate-500">ISBN: {{ $book->isbn ?: '-' }}</p>
                            </td>
                            <td>{{ $book->penulis }}</td>
                            <td>{{ $book->stok_tersedia }} / {{ $book->stok_total }}</td>
                            <td class="flex gap-2">
                                <a href="{{ route('admin.books.edit', $book) }}" class="chip">Edit</a>
                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-500">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $books->links() }}
    </section>
@endsection
