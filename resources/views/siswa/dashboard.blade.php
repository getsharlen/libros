@extends('layouts.app')

@section('content')
    <section class="panel p-8 reveal">
        <p class="eyebrow">Dashboard Siswa</p>
        <h2 class="font-display mt-2 text-3xl font-bold text-slate-900">Selamat Datang, {{ auth()->user()->name }}</h2>
        <p class="mt-3 text-slate-600">Gunakan menu peminjaman untuk mencari buku, mengajukan pinjam, dan melakukan
            pengembalian secara tertib.</p>

        <div class="hero-banner mt-5 grid gap-3 sm:grid-cols-3">
            @php
                $suggestions = ['Filosofi Teras', 'Bumi', 'Pulang'];
            @endphp
            @foreach ($suggestions as $suggestion)
                <img
                    src="https://picsum.photos/seed/{{ urlencode($suggestion) }}/280/140"
                    alt="Saran buku {{ $suggestion }}"
                    class="h-24 w-full rounded-xl border border-orange-200 object-cover"
                    loading="lazy"
                >
            @endforeach
        </div>

        <a class="btn-primary mt-6 inline-flex" href="{{ route('siswa.loans.index') }}">Lihat Peminjaman Saya</a>
    </section>
@endsection
