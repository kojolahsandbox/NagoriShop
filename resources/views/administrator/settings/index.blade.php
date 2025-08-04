@extends('administrator.layout.app')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengaturan Umum</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf

                {{-- PENGATURAN SLIDER --}}
                <h4><i class="fas fa-images mr-2"></i>Pengaturan Slider Beranda</h4>
                <p class="text-muted">Masukkan Link file gambar</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="slide_1">Gambar Slide 1</label>
                            <input type="text" id="slide_1" name="slide_1" class="form-control"
                                value="{{ $settings['slide_1'] ?? '' }}" placeholder="nama-file-gambar-1.png">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="slide_2">Gambar Slide 2</label>
                            <input type="text" id="slide_2" name="slide_2" class="form-control"
                                value="{{ $settings['slide_2'] ?? '' }}" placeholder="nama-file-gambar-2.png">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="slide_3">Gambar Slide 3</label>
                            <input type="text" id="slide_3" name="slide_3" class="form-control"
                                value="{{ $settings['slide_3'] ?? '' }}" placeholder="nama-file-gambar-3.png">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- PENGATURAN PROMOSI --}}
                <h4><i class="fas fa-tags mr-2"></i>Pengaturan Promosi</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount">Diskon Umum (%)</label>
                            <input type="text" id="discount" name="discount" class="form-control"
                                value="{{ $settings['discount'] ?? '0' }}" min="0" max="100">
                            <small class="form-text text-muted">Diskon umum yang berlaku untuk produk tertentu (diterapkan
                                manual).</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="promo_code">Kode Promo</label>
                            <input type="text" id="promo_code" name="promo_code" class="form-control"
                                value="{{ $settings['promo_code'] ?? '' }}" placeholder="Contoh: RAMADANHEMAT">
                            <small class="form-text text-muted">Kode promo yang bisa digunakan pelanggan saat
                                checkout.</small>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- PENGATURAN KONTAK --}}
                <h4><i class="fas fa-address-book mr-2"></i>Pengaturan Kontak</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="admin_contact">Kontak Admin (WhatsApp)</label>
                            <input type="text" id="admin_contact" name="admin_contact" class="form-control"
                                value="{{ $settings['admin_contact'] ?? '' }}" placeholder="Contoh: 6281234567890">
                            <small class="form-text text-muted">Nomor WhatsApp untuk bantuan pelanggan (gunakan format
                                62).</small>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </form>
        </div>
    </div>
@endsection
