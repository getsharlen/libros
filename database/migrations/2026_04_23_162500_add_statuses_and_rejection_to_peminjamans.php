<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new enum values and rejection reason column
        // For MySQL we modify the column directly using raw SQL to include new enum values.
        \DB::statement("ALTER TABLE `peminjamans` MODIFY `status` ENUM('menunggu','dipinjam','dikembalikan','terlambat','ditolak') NOT NULL DEFAULT 'dipinjam'");

        Schema::table('peminjamans', function (Blueprint $table) {
            if (! Schema::hasColumn('peminjamans', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum to original set and drop the alasan_penolakan column
        \DB::statement("ALTER TABLE `peminjamans` MODIFY `status` ENUM('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam'");

        Schema::table('peminjamans', function (Blueprint $table) {
            if (Schema::hasColumn('peminjamans', 'alasan_penolakan')) {
                $table->dropColumn('alasan_penolakan');
            }
        });
    }
};
