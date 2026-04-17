@extends('layouts.app')

@section('content')
    <section class="space-y-5">
        <article class="hero-banner reveal">
            <p class="eyebrow">Dashboard Admin</p>
            <h2 class="font-display mt-2 text-3xl font-extrabold text-slate-900">Operasional Perpustakaan</h2>
            <p class="mt-2 max-w-3xl text-slate-600">Kelola buku, anggota, dan transaksi dalam satu alur kerja yang rapi agar proses layanan lebih cepat dan minim kesalahan.</p>
        </article>

        <div class="grid gap-4 md:grid-cols-3">
            <article class="panel p-6 reveal">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold text-slate-900">Kelola Buku</h2>
            <p class="mt-2 text-slate-600">Tambah, ubah, dan kontrol stok buku perpustakaan.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.books.index') }}">Buka Modul</a>
            </article>
            <article class="panel p-6 reveal">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold text-slate-900">Kelola Anggota</h2>
            <p class="mt-2 text-slate-600">Manajemen data akun siswa aktif.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.members.index') }}">Buka Modul</a>
            </article>
            <article class="panel p-6 reveal">
            <p class="eyebrow">Menu Admin</p>
            <h2 class="font-display mt-2 text-2xl font-bold text-slate-900">Transaksi</h2>
            <p class="mt-2 text-slate-600">Pantau peminjaman, pengembalian, dan status keterlambatan.</p>
            <a class="btn-primary mt-4 inline-flex" href="{{ route('admin.transactions.index') }}">Buka Modul</a>
            </article>
        </div>
    </section>
@endsection
