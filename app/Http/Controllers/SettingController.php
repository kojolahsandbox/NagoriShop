<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan dengan semua opsi yang ada.
     */
    public function index()
    {
        // Mengambil semua pengaturan dan mengubahnya menjadi format yang mudah diakses di view
        // Contoh: 'site_name' => 'Nama Toko'
        $settings = Setting::pluck('option_value', 'option_key')->all();

        return view('administrator.settings.index', compact('settings'));
    }

    /**
     * Menyimpan atau memperbarui pengaturan.
     */
    public function update(Request $request)
    {
        // Validasi bisa ditambahkan di sini jika diperlukan
        // Contoh:
        // $request->validate([
        //     'site_name' => 'required|string|max:255',
        //     'contact_email' => 'required|email',
        //     'service_fee' => 'required|numeric|min:0|max:100',
        // ]);

        // Loop melalui semua data yang dikirim dari form
        foreach ($request->except('_token') as $key => $value) {
            // Gunakan updateOrCreate untuk membuat pengaturan jika belum ada,
            // atau memperbaruinya jika sudah ada.
            Setting::updateOrCreate(
                ['option_key' => $key],
                ['option_value' => $value]
            );
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}