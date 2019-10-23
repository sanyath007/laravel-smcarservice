<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Vehicle;
use App\Maintenance;
use App\Models\VehicleDailyCheck;

class MaintenanceController extends Controller
{
    public function index () {
        return view('maintenances.list', [
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
                                ->paginate(10),
            'maintenances' => Maintenance::with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->paginate(10)
        ]);
    }

    public function create ($vehicleid) {
        return view('maintenances.newform', [
            'vehicle' => Vehicle::where(['vehicle_id' => $vehicleid])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->first(),
        ]);
    }

    public function store (Request $req) {
        $newMaintained = new Maintenance();
        $newMaintained->garage_id = $req['garage'];
        $newMaintained->vehicle_id = $req['vehicle'];
        $newMaintained->mileage = $req['mileage'];
        $newMaintained->doc_date = $req['doc_date'];
        $newMaintained->doc_no = $req['doc_no'];
        $newMaintained->maintained_date = $req['maintained_date'];
        $newMaintained->receive_date = $req['receive_date'];
        $newMaintained->detail = $req['detail'];
        $newMaintained->remark = $req['remark'];
        $newMaintained->amt = $req['amt'];
        $newMaintained->vat = $req['vat'];
        $newMaintained->vatnet = $req['vatnet'];
        $newMaintained->total = $req['total'];
        $newMaintained->staff = $req['staff'];

        if ($newMaintained->save()) {
            return redirect('/maintained/list');
        }
    }

    public function edit ($maintainedid) {
        $maintenances = Maintenance::where(['vehicle_id' => $maintainedid])
                                ->with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->orderBy('maintain_date', 'DESC')
                                ->first();

        return view('maintenances.newform', [
            'vehicle' => Vehicle::where(['vehicle_id' => $id])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
        ]);
    }

    public function vehiclemaintain ($vehicleid) {
        return view('maintenances.vehicle', [
            'vehicle' => Vehicle::where(['vehicle_id' => $vehicleid])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->first(),
            'maintenances' => Maintenance::where(['vehicle_id' => $vehicleid])
                                ->with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->orderBy('maintained_date', 'DESC')
                                ->paginate(10)
        ]);
    }

    public function vehicleprint ($vehicleid) {
        return view('maintenances.vehicleprint', [
            'vehicle' => Vehicle::where(['vehicle_id' => $vehicleid])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->first(),
            'maintenances' => Maintenance::where(['vehicle_id' => $vehicleid])
                                ->where(['status' => '2'])
                                ->with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->orderBy('maintained_date', 'DESC')
                                ->get()
        ]);
    }

    public function checklist () 
    {
        return view('maintenances.checklist', [
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
                                ->get()
        ]);
    }

    public function ajaxchecklist ($checkdate, $vehicleid) 
    {
        $sdate = $checkdate. '-01';
        $edate = $checkdate. '-31';

        return [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->get(),
            'dailycheck' => VehicleDailyCheck::where(['vehicle_id' => $vehicleid])
                                                ->whereBetween('check_date', [$sdate, $edate])
                                                // ->where(['check_date' => $checkdate])
                                                ->orderBy('check_date', 'ASC')
                                                ->get()
        ];
    }


    public function checkform ($vehicleid) 
    {
        return view('maintenances.checkform', [
            'vehicle' => Vehicle::where(['vehicle_id' => $vehicleid])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->first(),
        ]);
    }

    public function storecheck (Request $req)
    {
        $dailycheck = new VehicleDailyCheck();
        $dailycheck->check_date = $req['check_date'];
        $dailycheck->user_id = $req['user_id'];
        $dailycheck->vehicle_id = $req['vehicle_id'];
        $dailycheck->current_mileage = $req['current_mileage'];
        $dailycheck->tires = $req['tires'];
        $dailycheck->tires_text = $req['tires_text'];
        $dailycheck->leak = $req['leak'];
        $dailycheck->leak_text = $req['leak_text'];
        $dailycheck->radiator = $req['radiator'];
        $dailycheck->radiator_text = $req['radiator_text'];
        $dailycheck->oil = $req['oil'];
        $dailycheck->oil_text = $req['oil_text'];
        $dailycheck->brake_clutch = $req['brake_clutch'];
        $dailycheck->brake_clutch_text = $req['brake_clutch_text'];
        $dailycheck->battery = $req['battery'];
        $dailycheck->battery_text = $req['battery_text'];
        $dailycheck->windshield = $req['windshield'];
        $dailycheck->windshield_text = $req['windshield_text'];
        $dailycheck->fuel = $req['fuel'];
        $dailycheck->fuel_text = $req['fuel_text'];
        $dailycheck->gauges = $req['gauges'];
        $dailycheck->gauges_text = $req['gauges_text'];
        $dailycheck->lights = $req['lights'];
        $dailycheck->lights_text = $req['lights_text'];
        $dailycheck->oxygen = $req['oxygen'];
        $dailycheck->oxygen_text = $req['oxygen_text'];
        $dailycheck->siren = $req['siren'];
        $dailycheck->siren_text = $req['siren_text'];
        $dailycheck->radio = $req['radio'];
        $dailycheck->radio_text = $req['radio_text'];
        $dailycheck->damage = $req['damage'];
        $dailycheck->damage_text = $req['damage_text'];
        $dailycheck->is_washed = $req['is_washed'];
        // $dailycheck->car_washed_front = $req['car_washed_front'];
        // $dailycheck->car_washed_back = $req['car_washed_back'];
        // $dailycheck->car_washed_left = $req['car_washed_left'];
        // $dailycheck->car_washed_right = $req['car_washed_right'];
        $dailycheck->remark = $req['remark'];

        if ($dailycheck->save()) {
            // print_r($dailycheck);
            return redirect('/maintained/checklist');
        }
    }
}
