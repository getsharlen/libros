<label class="field">
    <span>Kode Buku</span>
    <input type="text" name="kode_buku" value="{{ old('kode_buku', $book->kode_buku ?? '') }}" required>
</label>
<label class="field">
    <span>Judul</span>
    <input type="text" name="judul" value="{{ old('judul', $book->judul ?? '') }}" required>
</label>
<label class="field">
    <span>Penulis</span>
    <input type="text" name="penulis" value="{{ old('penulis', $book->penulis ?? '') }}" required>
</label>
<label class="field">
    <span>Penerbit</span>
    <input type="text" name="penerbit" value="{{ old('penerbit', $book->penerbit ?? '') }}">
</label>
<label class="field">
    <span>Tahun Terbit</span>
    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}" min="1900" max="2100">
</label>
<label class="field">
    <span>ISBN</span>
    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}">
</label>
<label class="field">
    <span>Stok Total</span>
    <input type="number" name="stok_total" value="{{ old('stok_total', $book->stok_total ?? 0) }}" min="0" required>
</label>
<label class="field">
    <span>Stok Tersedia</span>
    <input type="number" name="stok_tersedia" value="{{ old('stok_tersedia', $book->stok_tersedia ?? 0) }}" min="0" required>
</label>
<label class="field md:col-span-2">
    <span>Lokasi Rak</span>
    <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak', $book->lokasi_rak ?? '') }}">
</label>
