<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdministratorController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kotak Statistik
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['completed'])->sum('total_amount');
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // 2. Data untuk Grafik Penjualan (12 Bulan Terakhir)
        $salesData = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->whereIn('status', ['completed'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = [];
        $chartData = [];
        // Inisialisasi data 12 bulan dengan 0
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M'); // e.g., 'Jan', 'Feb'
            $year = $month->format('y');
            $chartLabels[] = $monthName . " '" . $year;
            $chartData[$month->format('Y-n')] = 0;
        }

        // Isi data penjualan dari database
        foreach ($salesData as $sale) {
            $key = $sale->year . '-' . $sale->month;
            if (isset($chartData[$key])) {
                $chartData[$key] = $sale->total;
            }
        }

        // 3. Data untuk Aktivitas Terbaru
        // Mengambil 5 pesanan terbaru sebagai representasi aktivitas
        $recentActivities = Order::with('user')->latest()->take(5)->get();

        // Mengirim semua data ke view
        return view('administrator.dashboard', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'chartLabels' => array_values($chartLabels),
            'chartData' => array_values($chartData), // Kirim sebagai array numerik
            'recentActivities' => $recentActivities
        ]);
    }
}