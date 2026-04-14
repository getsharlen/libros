@extends('layouts.app')

@section('content')
    <section class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-display text-3xl font-bold">Data Anggota</h2>
            <a href="{{ route('admin.members.create') }}" class="btn-primary">Tambah Anggota</a>
        </div>

        <form method="GET" class="panel p-4">
            <label class="field">
                <span>Cari Nama</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Masukkan nama siswa">
            </label>
        </form>

        <div class="panel overflow-x-auto">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->nis }}</td>
                            <td class="flex gap-2">
                                <a href="{{ route('admin.members.edit', $member) }}" class="chip">Edit</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-slate-300">Belum ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $members->links() }}
    </section>
@endsection
