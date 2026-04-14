@extends('layouts.app')

@section('content')
    <section class="panel p-6">
        <h2 class="font-display text-3xl font-bold">Detail Anggota</h2>
        <dl class="mt-4 grid gap-3 md:grid-cols-2">
            <div><dt class="eyebrow">Nama</dt><dd>{{ $member->name }}</dd></div>
            <div><dt class="eyebrow">Email</dt><dd>{{ $member->email }}</dd></div>
            <div><dt class="eyebrow">NIS</dt><dd>{{ $member->nis }}</dd></div>
            <div><dt class="eyebrow">No Telepon</dt><dd>{{ $member->no_telp }}</dd></div>
        </dl>
    </section>
@endsection
