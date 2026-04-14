@extends('layouts.app')

@section('content')
    <section class="panel p-8">
        <p class="eyebrow">Dashboard Siswa</p>
        <h2 class="font-display mt-2 text-3xl font-bold text-white">Selamat Datang, {{ auth()->user()->name }}</h2>
        <p class="mt-3 text-slate-200/80">Gunakan menu peminjaman untuk mencari buku, mengajukan pinjam, dan melakukan
            pengembalian secara tertib.</p>
        <a class="btn-primary mt-6 inline-flex" href="{{ route('siswa.loans.index') }}">Lihat Peminjaman Saya</a>
    </section>
@endsection
