{{-- Menggunakan kerangka utama dari layouts/app.blade.php --}}
@extends('administrator.layout.app')

{{-- Mengisi judul halaman --}}
@section('title', 'Dashboard')

{{-- Mengisi konten utama halaman --}}
@section('content')

    {{-- AWAL PERUBAHAN: Data Statistik Dinamis --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Pesanan</p>
                </div>
                <a href="{{ route('orders.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <a href="{{ route('orders.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Produk</p>
                </div>
                <a href="{{ route('products.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Total Pelanggan</p>
                </div>
                <a href="{{ route('customers.index') }}" class="small-box-footer">Lihat Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    {{-- AKHIR PERUBAHAN --}}


    <div class="row">
        {{-- Grafik Penjualan --}}
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i>Grafik Penjualan 12 Bulan Terakhir</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="salesChart"
                            style="min-height: 250px; height: 300px; max-height: 350px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- AWAL PERUBAHAN: Aktivitas Terbaru Dinamis --}}
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history mr-1"></i>Aktivitas Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($recentActivities as $activity)
                            <li class="list-group-item">
                                <i class="fas fa-shopping-cart text-primary mr-2"></i>
                                Pesanan baru oleh <b>{{ $activity->user->name ?? 'N/A' }}</b>
                                <a href="{{ route('orders.show', $activity->id) }}"
                                    class="float-right text-muted text-sm">{{ $activity->created_at->diffForHumans() }}</a>
                            </li>
                        @empty
                            <li class="list-group-item">
                                Tidak ada aktivitas terbaru.
                            </li>
                        @endforelse
                        <li class="list-group-item text-center">
                            <a href="{{ route('orders.index') }}">Lihat Semua Pesanan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- AKHIR PERUBAHAN --}}
    </div>

@endsection

{{-- Script untuk Chart.js --}}
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- AWAL PERUBAHAN: Data Grafik Dinamis --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengambil data dari controller yang di-pass ke view
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            const salesData = {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: chartData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            };

            const salesOptions = {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                // Format angka menjadi lebih ringkas (misal: 1000000 -> 1 Jt)
                                if (value >= 1000000) {
                                    return (value / 1000000) + ' Jt';
                                }
                                if (value >= 1000) {
                                    return (value / 1000) + ' Rb';
                                }
                                return value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false, // Sembunyikan legenda karena label sudah jelas
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    // Format tooltip menjadi format mata uang Rupiah
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            };

            const salesChartCanvas = document.getElementById('salesChart').getContext('2d');

            new Chart(salesChartCanvas, {
                type: 'line',
                data: salesData,
                options: salesOptions
            });
        });
    </script>
    {{-- AKHIR PERUBAHAN --}}
@endsection
