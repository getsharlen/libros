@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-4xl panel p-8 md:p-10 reveal">
        <p class="eyebrow">Registrasi Siswa</p>
        <h2 class="font-display mt-2 text-3xl font-extrabold text-slate-900">Buat Akun Baru</h2>
        <p class="mt-2 text-slate-600">Isi data dengan benar agar proses peminjaman berjalan lancar.</p>

        <div class="hero-banner mt-5 grid gap-3 sm:grid-cols-3">
            @php
                $starterCovers = ['Negeri 5 Menara', 'Dilan 1990', 'Sang Pemimpi'];
            @endphp
            @foreach ($starterCovers as $starterCover)
                <img
                    src="https://picsum.photos/seed/{{ urlencode($starterCover) }}/180/120"
                    alt="Preview buku {{ $starterCover }}"
                    class="h-20 w-full rounded-xl border border-orange-200 object-cover"
                    loading="lazy"
                >
            @endforeach
        </div>

        <form method="POST" action="{{ route('register') }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            <label class="field md:col-span-2">
                <span>Nama Lengkap</span>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>
            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label class="field">
                <span>NIS</span>
                <input type="text" name="nis" value="{{ old('nis') }}" required>
            </label>
            <label class="field">
                <span>No Telepon</span>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}">
            </label>
            <label class="field">
                <span>Alamat</span>
                <input type="text" name="alamat" value="{{ old('alamat') }}">
            </label>
            <label class="field">
                <span>Password</span>
                <input type="password" name="password" required>
            </label>
            <label class="field">
                <span>Konfirmasi Password</span>
                <input type="password" name="password_confirmation" required>
            </label>
            <div class="md:col-span-2 flex items-center gap-3">
                <button type="submit" class="btn-primary">Daftar</button>
                <a href="{{ route('login.form') }}" class="chip">Kembali ke Login</a>
            </div>
        </form>
    </section>
@endsection
