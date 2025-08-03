{{-- Menggunakan kerangka utama dari layouts/app.blade.php --}}
@extends('administrator.layout.app')

{{-- Mengisi judul halaman --}}
@section('title', 'Dashboard')

{{-- Mengisi konten utama halaman --}}
@section('content')

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>👜1500</h3>
                    <p>Total Pesanan</p>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>💸 53.000.000</h3>
                    <p>Total Pendapatan</p>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>📦 440</h3>
                    <p>Total Produk</p>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>👥 6500</h3>
                    <p>Total Pelanggan</p>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        {{-- Grafik Penjualan --}}
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i>Grafik Penjualan</h3>
                </div>
                <div class="card-body">
                    {{-- Canvas untuk Chart.js --}}
                    <div class="chart">
                        <canvas id="salesChart"
                            style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history mr-1"></i>Aktivitas Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-user-plus text-success mr-2"></i> Pelanggan baru, <b>Budi Santoso</b>,
                            mendaftar.
                            <span class="float-right text-muted text-sm">3 menit lalu</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-shopping-cart text-primary mr-2"></i> Pesanan baru <b>#INV-0078</b> diterima.
                            <span class="float-right text-muted text-sm">15 menit lalu</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-box text-warning mr-2"></i> Produk <b>"Kemeja Flanel"</b> kehabisan stok.
                            <span class="float-right text-muted text-sm">1 jam lalu</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-money-bill-wave text-info mr-2"></i> Pembayaran untuk pesanan <b>#INV-0075</b>
                            dikonfirmasi.
                            <span class="float-right text-muted text-sm">3 jam lalu</span>
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-shopping-cart text-primary mr-2"></i> Pesanan baru <b>#INV-0077</b> diterima.
                            <span class="float-right text-muted text-sm">5 jam lalu</span>
                        </li>
                        <li class="list-group-item text-center">
                            <a href="#">Lihat Semua Aktivitas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Script untuk Chart.js --}}
@section('script')
    {{-- Memuat library Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data contoh untuk grafik penjualan (gantilah dengan data dinamis Anda)
            const salesData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"],
                datasets: [{
                    label: 'Penjualan (dalam Juta Rp)',
                    data: [12, 19, 8, 15, 20, 13, 25], // Data penjualan fiktif
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4 // Membuat garis lebih melengkung
                }]
            };

            // Opsi untuk grafik
            const salesOptions = {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Menambahkan format "Jt" pada sumbu Y
                            callback: function(value, index, values) {
                                return value + ' Jt';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed.y * 1000000);
                                }
                                return label;
                            }
                        }
                    }
                }
            };

            // Mendapatkan elemen canvas
            const salesChartCanvas = document.getElementById('salesChart').getContext('2d');

            // Membuat grafik baru
            new Chart(salesChartCanvas, {
                type: 'line', // Tipe grafik: line, bar, pie, dll.
                data: salesData,
                options: salesOptions
            });
        });
    </script>
@endsection
