@extends('layouts.app')

@section('content')
    <section class="panel p-6">
        <h2 class="font-display text-3xl font-bold">Detail Buku</h2>
        <dl class="mt-4 grid gap-3 md:grid-cols-2">
            <div><dt class="eyebrow">Kode</dt><dd>{{ $book->kode_buku }}</dd></div>
            <div><dt class="eyebrow">Judul</dt><dd>{{ $book->judul }}</dd></div>
            <div><dt class="eyebrow">Penulis</dt><dd>{{ $book->penulis }}</dd></div>
            <div><dt class="eyebrow">Stok</dt><dd>{{ $book->stok_tersedia }} / {{ $book->stok_total }}</dd></div>
        </dl>
    </section>
@endsection
