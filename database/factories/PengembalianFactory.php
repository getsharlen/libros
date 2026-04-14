<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengembalian>
 */
class PengembalianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $peminjaman = Peminjaman::leftJoin('pengembalians', 'peminjamans.id', '=', 'pengembalians.peminjaman_id')
            ->whereNull('pengembalians.id')
            ->inRandomOrder()
            ->first(['peminjamans.*']) ?? Peminjaman::factory()->create();

        $tanggalJatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $terlambat = fake()->boolean(40);
        $tanggalKembali = $terlambat
            ? $tanggalJatuhTempo->clone()->addDays(fake()->randomElement([1, 2, 3, 5]))->format('Y-m-d')
            : $tanggalJatuhTempo->clone()->subDays(fake()->randomElement([0, 1, 2, 3]))->format('Y-m-d');

        $hariTerlambat = max(0, (int) \Carbon\Carbon::parse($tanggalKembali)->diffInDays($tanggalJatuhTempo, false));
        $denda = $hariTerlambat > 0 ? $hariTerlambat * 1000 : 0;

        return [
            'peminjaman_id' => $peminjaman->id,
            'processed_by' => User::where('role', 'admin')->inRandomOrder()->first()?->id ?? User::factory()->admin(),
            'tanggal_kembali' => $tanggalKembali,
            'denda' => $denda,
            'catatan_kondisi' => fake()->randomElement([null, 'Baik', 'Ada lecet kecil', 'Rusak di sampul']),
        ];
    }
}
