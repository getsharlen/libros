@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-display text-3xl font-bold">Manajemen Buku</h2>
            <a href="{{ route('admin.books.create') }}" class="btn-primary">Tambah Buku</a>
        </div>

        <form method="GET" class="panel p-4">
            <label class="field">
                <span>Cari Judul</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Masukkan judul buku">
            </label>
        </form>

        <div class="panel overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
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
                            <td>{{ $book->kode_buku }}</td>
                            <td>{{ $book->judul }}</td>
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
                            <td colspan="5" class="text-center text-slate-300">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $books->links() }}
    </section>
@endsection
