@extends('layouts.app')

@section('content')
    <section class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <article class="panel p-8 md:p-10">
            <p class="eyebrow">UKK Paket 4 2025/2026</p>
            <h2 class="font-display mt-2 text-3xl font-extrabold leading-tight text-white md:text-5xl">Masuk ke Sistem
                Perpustakaan Digital</h2>
            <p class="mt-4 max-w-xl text-slate-200/80">Kelola proses peminjaman buku lebih cepat, tertib, dan terpantau untuk
                admin maupun siswa.</p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                <div class="stat-card">
                    <p class="text-xs uppercase tracking-[0.16em] text-cyan-200">Role</p>
                    <p class="mt-1 text-lg font-semibold">Admin dan Siswa</p>
                </div>
                <div class="stat-card">
                    <p class="text-xs uppercase tracking-[0.16em] text-cyan-200">Validasi</p>
                    <p class="mt-1 text-lg font-semibold">Role Middleware Aktif</p>
                </div>
            </div>
        </article>

        <article class="panel p-8">
            <h3 class="font-display text-2xl font-bold text-white">Login</h3>
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
            <p class="mt-4 text-sm text-slate-300">Belum punya akun? <a href="{{ route('register.form') }}"
                    class="text-cyan-300 hover:text-cyan-200">Daftar siswa</a></p>
        </article>
    </section>
@endsection
