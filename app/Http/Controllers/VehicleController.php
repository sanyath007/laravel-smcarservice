<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Vehicle;
use App\Driver;

class VehicleController extends Controller
{
    public function index () {
        return view('vehicles.list', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->with('taxactived')                          
                                ->orderBy('vehicle_no', 'ASC')
                                ->orderBy('vehicle_cate', 'ASC')
                                ->paginate(15)
        ]);
    }

    public function ajaxvehicles () {
        return [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')                                
                                ->orderBy('vehicle_type', 'ASC')
                                ->orderBy('vehicle_cate', 'ASC')
                                ->paginate(10)
        ];
    }
}
