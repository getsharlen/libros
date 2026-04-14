<label class="field md:col-span-2">
    <span>Nama</span>
    <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" required>
</label>
<label class="field">
    <span>Email</span>
    <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" required>
</label>
<label class="field">
    <span>NIS</span>
    <input type="text" name="nis" value="{{ old('nis', $member->nis ?? '') }}" required>
</label>
<label class="field">
    <span>No Telepon</span>
    <input type="text" name="no_telp" value="{{ old('no_telp', $member->no_telp ?? '') }}">
</label>
<label class="field">
    <span>Alamat</span>
    <input type="text" name="alamat" value="{{ old('alamat', $member->alamat ?? '') }}">
</label>
<label class="field">
    <span>Password {{ isset($member) ? '(opsional)' : '' }}</span>
    <input type="password" name="password" {{ isset($member) ? '' : 'required' }}>
</label>
<label class="field">
    <span>Konfirmasi Password</span>
    <input type="password" name="password_confirmation" {{ isset($member) ? '' : 'required' }}>
</label>
