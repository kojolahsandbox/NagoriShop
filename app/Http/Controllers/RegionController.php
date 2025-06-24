<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;


class RegionController extends Controller
{
    public function getProvince()
    {
        return Province::select('id', 'name')->get();
    }

    public function getCity($province_id)
    {
        return Regency::where('province_id', $province_id)->select('id', 'name')->get();
    }

    public function getDistrict($regency_id)
    {
        return District::where('regency_id', $regency_id)->select('id', 'name')->get();
    }

    public function getVillage($district_id)
    {
        return Village::where('district_id', $district_id)->select('id', 'name')->get();
    }
}