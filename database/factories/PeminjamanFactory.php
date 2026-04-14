<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = Carbon::instance(fake()->dateTimeBetween('-60 days', '-5 days'));
        $durasi = fake()->randomElement([7, 10, 14]);

        return [
            'user_id' => User::factory()->siswa(),
            'book_id' => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_jatuh_tempo' => $tanggalPinjam->clone()->addDays($durasi)->format('Y-m-d'),
            'status' => fake()->randomElement(['dipinjam', 'dikembalikan', 'terlambat']),
            'catatan' => fake()->randomElement([null, 'Kondisi baik', 'Halaman rusak']),
        ];
    }
}
