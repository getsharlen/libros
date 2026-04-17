<header class="glass mb-6 flex flex-wrap items-center justify-between gap-4 p-4 md:p-5 reveal">
    <div>
        <p class="text-xs uppercase tracking-[0.2em] text-orange-600">Libros</p>
        <h1 class="font-display text-xl font-bold text-slate-900 md:text-2xl">Perpustakaan Digital</h1>
        <p class="mt-1 text-xs text-slate-500">Platform pinjam buku yang cepat dan tertata</p>
    </div>

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        @if (auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="chip">Dashboard</a>
            <a href="{{ route('admin.books.index') }}" class="chip">Buku</a>
            <a href="{{ route('admin.members.index') }}" class="chip">Anggota</a>
            <a href="{{ route('admin.transactions.index') }}" class="chip">Transaksi</a>
        @else
            <a href="{{ route('siswa.dashboard') }}" class="chip">Dashboard</a>
            <a href="{{ route('siswa.loans.index') }}" class="chip">Peminjaman Saya</a>
        @endif
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-danger">Logout</button>
    </form>
</header>
