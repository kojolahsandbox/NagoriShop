@extends('administrator.layout.app')

@section('title', 'Edit Penjual')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Penjual</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('sellers.update', $seller->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $seller->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $seller->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $seller->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="active" {{ old('status', $seller->status) == 'active' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="inactive"
                                    {{ old('status', $seller->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Alamat Penjual</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select id="provinsi" name="province"
                                class="form-control @error('province') is-invalid @enderror" required></select>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kota">Kota/Kabupaten</label>
                            <select id="kota" name="city" class="form-control @error('city') is-invalid @enderror"
                                required></select>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select id="kecamatan" name="district"
                                class="form-control @error('district') is-invalid @enderror" required></select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan/Desa</label>
                            <select id="kelurahan" name="village"
                                class="form-control @error('village') is-invalid @enderror" required></select>
                            @error('village')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Alamat Lengkap</label>
                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $seller->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h5>Keamanan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('sellers.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
            const provinsiSelect = document.getElementById('provinsi');
            const kotaSelect = document.getElementById('kota');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');

            // Data alamat dari seller atau old input
            const storedData = {
                province: "{{ old('province', $seller->province ?? '') }}",
                city: "{{ old('city', $seller->city ?? '') }}",
                district: "{{ old('district', $seller->district ?? '') }}",
                village: "{{ old('village', $seller->village ?? '') }}"
            };

            // Load Provinsi
            fetch(`${baseUrl}/provinces.json`)
                .then(res => res.json())
                .then(data => {
                    provinsiSelect.innerHTML = `<option value="">Pilih Provinsi</option>`;
                    data.forEach(prov => {
                        provinsiSelect.innerHTML +=
                            `<option value="${prov.id}" ${prov.id == storedData.province ? 'selected' : ''}>${prov.name}</option>`;
                    });
                    if (storedData.province) provinsiSelect.dispatchEvent(new Event('change'));
                });

            // Event listener untuk Provinsi
            provinsiSelect.addEventListener('change', function() {
                const provinceId = this.value;
                if (!provinceId) return;
                fetch(`${baseUrl}/regencies/${provinceId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kotaSelect.innerHTML = `<option value="">Pilih Kota/Kabupaten</option>`;
                        kecamatanSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kota => {
                            kotaSelect.innerHTML +=
                                `<option value="${kota.id}" ${kota.id == storedData.city ? 'selected' : ''}>${kota.name}</option>`;
                        });
                        if (storedData.city) kotaSelect.dispatchEvent(new Event('change'));
                    });
            });

            // Event listener untuk Kota/Kabupaten
            kotaSelect.addEventListener('change', function() {
                const cityId = this.value;
                if (!cityId) return;
                fetch(`${baseUrl}/districts/${cityId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kecamatanSelect.innerHTML = `<option value="">Pilih Kecamatan</option>`;
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kec => {
                            kecamatanSelect.innerHTML +=
                                `<option value="${kec.id}" ${kec.id == storedData.district ? 'selected' : ''}>${kec.name}</option>`;
                        });
                        if (storedData.district) kecamatanSelect.dispatchEvent(new Event('change'));
                    });
            });

            // Event listener untuk Kecamatan
            kecamatanSelect.addEventListener('change', function() {
                const districtId = this.value;
                if (!districtId) return;
                fetch(`${baseUrl}/villages/${districtId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        kelurahanSelect.innerHTML = `<option value="">Pilih Kelurahan</option>`;
                        data.forEach(kel => {
                            kelurahanSelect.innerHTML +=
                                `<option value="${kel.id}" ${kel.id == storedData.village ? 'selected' : ''}>${kel.name}</option>`;
                        });
                    });
            });
        });
    </script>
@endsection
