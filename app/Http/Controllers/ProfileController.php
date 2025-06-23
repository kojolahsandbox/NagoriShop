<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Profile',
        ];

        return view('customer.profile', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // ubah no hp dari 08 atau 628 menjadi 628 semuanya 
        $phone = $request->phone;
        if (substr($phone, 0, 2) == '08') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) == '628') {
            $phone = '62' . substr($phone, 3);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $phone;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->district = $request->district;
        $user->village = $request->village;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil Berhasil diperbaharui!');
    }
}
