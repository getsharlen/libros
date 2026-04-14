@extends('layouts.app')

@section('content')
    <section class="panel max-w-4xl p-6">
        <h2 class="font-display text-3xl font-bold">Edit Anggota</h2>
        <form method="POST" action="{{ route('admin.members.update', $member) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @method('PUT')
            @include('admin.members.form')
            <div class="md:col-span-2">
                <button class="btn-primary" type="submit">Update Anggota</button>
            </div>
        </form>
    </section>
@endsection
