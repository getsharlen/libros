<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@libros.test',
        ], [
            'name' => 'Admin Perpustakaan',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'nis' => null,
            'no_telp' => '081200000001',
            'alamat' => 'Ruang Tata Usaha',
        ]);

        User::factory()->admin()->createOne([
            'email' => 'admin2@libros.test',
            'name' => 'Administator 2',
        ]);

        User::query()->updateOrCreate([
            'email' => 'siswa@libros.test',
        ], [
            'name' => 'Siswa Contoh',
            'password' => Hash::make('siswa12345'),
            'role' => 'siswa',
            'nis' => 'NIS-001',
            'no_telp' => '081200000002',
            'alamat' => 'Kelas XII RPL',
        ]);

        User::factory()->siswa()->count(25)->create();

        \App\Models\Book::factory()->count(22)->create();

        \App\Models\Peminjaman::factory()->count(25)->create();

        // Create returns for first 12 peminjamans only (to avoid constraint violations)
        $peminjamans = \App\Models\Peminjaman::orderBy('id')->limit(12)->get();
        foreach ($peminjamans as $peminjaman) {
            \App\Models\Pengembalian::factory()->create([
                'peminjaman_id' => $peminjaman->id,
            ]);
        }
    }
}
