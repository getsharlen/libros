<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_tidak_bisa_akses_menu_admin(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'nis' => 'NIS-ROLE-01',
        ]);

        $response = $this->actingAs($siswa)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_bisa_menambah_buku(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'nis' => null,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.books.store'), [
            'kode_buku' => 'BK-001',
            'judul' => 'Arsitektur Perangkat Lunak',
            'penulis' => 'Tim UKK',
            'penerbit' => 'Sekolah',
            'tahun_terbit' => 2026,
            'isbn' => '9786020000001',
            'stok_total' => 10,
            'stok_tersedia' => 10,
            'lokasi_rak' => 'A-01',
        ]);

        $response->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseHas('books', [
            'kode_buku' => 'BK-001',
            'judul' => 'Arsitektur Perangkat Lunak',
            'stok_tersedia' => 10,
        ]);
    }

    public function test_siswa_pinjam_lalu_kembali_terlambat_mendapat_denda_otomatis(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'nis' => 'NIS-LOAN-01',
        ]);

        $book = Book::query()->create([
            'kode_buku' => 'BK-LOAN-01',
            'judul' => 'Pemrograman Web',
            'penulis' => 'Guru RPL',
            'penerbit' => 'SMK',
            'tahun_terbit' => 2025,
            'isbn' => '9786020000002',
            'stok_total' => 3,
            'stok_tersedia' => 3,
            'lokasi_rak' => 'B-02',
        ]);

        $this->actingAs($siswa)->post(route('siswa.loans.store'), [
            'book_id' => $book->id,
            'durasi_hari' => 2,
        ])->assertRedirect(route('siswa.loans.index'));

        $loan = Peminjaman::query()->where('user_id', $siswa->id)->firstOrFail();
        $loan->update([
            'tanggal_jatuh_tempo' => now()->subDay()->toDateString(),
            'status' => 'dipinjam',
        ]);

        $this->actingAs($siswa)->post(route('siswa.loans.return', $loan), [
            'tanggal_kembali' => now()->toDateString(),
        ])->assertRedirect(route('siswa.loans.index'));

        $loan->refresh();

        $this->assertSame('terlambat', $loan->status);

        $this->assertDatabaseHas('pengembalians', [
            'peminjaman_id' => $loan->id,
            'denda' => 1000.00,
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stok_tersedia' => 3,
        ]);
    }
}
