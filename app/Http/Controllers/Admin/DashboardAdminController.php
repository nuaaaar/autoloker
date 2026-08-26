<?php

namespace App\Http\Controllers\Admin;

use Laravolt\Indonesia\Models\Province;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $data['provinces'] = Province::all()
        ->map(function($province){

            $meta = $province->meta;


            return [
                'id'   => $province->id,
                'name' => $province->name,
                'lat'  => (float) $meta['lat'],
                'lng'  => (float) $meta['long'],
            ];

        })
        ->values()
        ->toArray();

        return view('dashboard-admin.index', $data);
    }
}
