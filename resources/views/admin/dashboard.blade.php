@extends('layouts.app')

@section('content')
    <section class="grid gap-4 md:grid-cols-3">
        <article class="panel p-6">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold">Kelola Buku</h2>
            <p class="mt-2 text-slate-200/80">Tambah, ubah, dan kontrol stok buku perpustakaan.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.books.index') }}">Buka Modul</a>
        </article>
        <article class="panel p-6">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold">Kelola Anggota</h2>
            <p class="mt-2 text-slate-200/80">Manajemen data akun siswa aktif.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.members.index') }}">Buka Modul</a>
        </article>
        <article class="panel p-6">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold">Transaksi</h2>
            <p class="mt-2 text-slate-200/80">Pantau peminjaman, pengembalian, dan status keterlambatan.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.transactions.index') }}">Buka Modul</a>
        </article>
    </section>
@endsection
