@extends('layouts.app')

@section('content')
    <section class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <article class="panel p-8 md:p-10 reveal">
            <p class="eyebrow">UKK Paket 4 2025/2026</p>
            <h2 class="font-display mt-2 text-3xl font-extrabold leading-tight text-slate-900 md:text-5xl">Masuk ke Sistem
                Perpustakaan Digital</h2>
            <p class="mt-4 max-w-xl text-slate-600">Kelola proses peminjaman buku lebih cepat, tertib, dan terpantau untuk
                admin maupun siswa dengan tampilan yang nyaman digunakan.</p>

            <div class="hero-banner mt-6">
                <p class="text-sm font-semibold text-slate-700">Rekomendasi Buku Hari Ini</p>
                <div class="mt-3 grid grid-cols-3 gap-3">
                    @php
                        $showcaseBooks = ['Laskar Pelangi', 'Bumi Manusia', 'Atomic Habits'];
                    @endphp
                    @foreach ($showcaseBooks as $showcaseBook)
                        <figure>
                            <img
                                src="https://picsum.photos/seed/{{ urlencode($showcaseBook) }}/140/200"
                                alt="Cover buku {{ $showcaseBook }}"
                                class="book-cover h-28 w-full"
                                loading="lazy"
                            >
                            <figcaption class="mt-2 line-clamp-2 text-xs font-semibold text-slate-700">{{ $showcaseBook }}</figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                <div class="stat-card">
                    <p class="text-xs uppercase tracking-[0.16em] text-orange-700">Role</p>
                    <p class="mt-1 text-lg font-semibold text-slate-800">Admin dan Siswa</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs uppercase tracking-[0.16em] text-orange-700">Validasi</p>
                    <p class="mt-1 text-lg font-semibold text-slate-800">Role Middleware Aktif</p>
                </div>
            </div>
        </article>

        <article class="panel p-8 reveal">
            <h3 class="font-display text-2xl font-bold text-slate-900">Login</h3>
            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <label class="field">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label class="field">
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>
                <button type="submit" class="btn-primary w-full">Masuk</button>
            </form>
            <p class="mt-4 text-sm text-slate-600">Belum punya akun? <a href="{{ route('register.form') }}"
                    class="font-semibold text-orange-600 hover:text-orange-500">Daftar siswa</a></p>
        </article>
    </section>
@endsection
