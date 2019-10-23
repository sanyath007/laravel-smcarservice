<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Vehicle;
use App\VehicleFuel;
use App\FuelType;

class FuelController extends Controller
{
	public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'department' => 'required',
            'fuel_type' => 'required',
            'vehicle_id' => 'required',
            'bill_no' => 'required',
            'bill_date' => 'required',
            'volume' => 'required',
            'unit_price' => 'required',
            'total' => 'required',
            'job_desc' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        } else {
            return [
                'success' => 1,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        }
    }

    public function index ()
    {
        if (!empty(Input::get('_month'))) {
            $sdate  = Input::get('_month').'-01';
            $edate  = date("Y-m-t", strtotime($sdate));
        } else {
            $sdate  = date("Y-m") . '-01';
            $edate  = date("Y-m-t", strtotime($sdate));
        }

    	return view('fuel.list', [
    		'fuels'		=> VehicleFuel::whereBetween('bill_date', [$sdate, $edate])
    								->with('vehicle')
    								->with('fuel_type')
    								->orderBy('bill_date', 'ASC')
    								->paginate(15),
    		'vehicles'	=> Vehicle::whereIn('status', ['1','9'])
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
                                	->get(),
            '_month'    => (!Input::get('_month')) ? date('Y-m') : Input::get('_month'),
    	]);
    }

    public function create ()
    {
    	return view('fuel.newform', [
    		'fuel_types'	=> FuelType::all(),
    		'vehicles'		=> Vehicle::whereIn('status', ['1','9'])
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
                                	->get(),
    	]);
    }

    public function store (Request $req)
    {
    	$vf = new VehicleFuel();
    	$vf->department 	= $req['department'];
        $vf->vehicle_id 	= $req['vehicle'];
		$vf->fuel_type_id 	= $req['fuel_type'];
		$vf->bill_no 		= $req['bill_no'];
		$vf->bill_date 		= $req['bill_date'];
		$vf->volume 		= $req['volume'];
		$vf->unit_price 	= $req['unit_price'];
		$vf->total 			= $req['total'];
        $vf->job_desc       = $req['job_desc'];
        $vf->remark         = $req['remark'];
        $vf->status 		= '1';

        if($vf->save()) {
    		return redirect('/fuel/new')->with('status', 'บันทึกข้อมูลเรียบร้อย');
    	} else {
    		return redirect('/fuel/new')->with('status', 'พบข้อผิดพลาด');
    	}
    }

    public function edit ($id) 
    {
        $fuel = VehicleFuel::find($id);

        return view('fuel.editform', [
            'fuel'         => $fuel,
            'fuel_types'    => FuelType::all(),
            'vehicles'      => Vehicle::whereIn('status', ['1','9'])
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
                                    ->get(),
        ]);
    }

    public function update(Request $req) 
    {
        $vf = VehicleFuel::find($req['id']);
        $vf->department     = $req['department'];
        $vf->vehicle_id     = $req['vehicle'];
        $vf->fuel_type_id   = $req['fuel_type'];
        $vf->bill_no        = $req['bill_no'];
        $vf->bill_date      = $req['bill_date'];
        $vf->volume         = $req['volume'];
        $vf->unit_price     = $req['unit_price'];
        $vf->total          = $req['total'];
        $vf->job_desc       = $req['job_desc'];
        $vf->remark         = $req['remark'];

        if($vf->save()) {
            return redirect('/fuel/list')->with('status', 'บันทึกข้อมูลเรียบร้อย');
        } else {
            return redirect('/fuel/remark')->with('status', 'พบข้อผิดพลาด');
        }
    }

    public function delete (Request $req) 
    {
        $fuel = VehicleFuel::find($req['_id'])->delete();
        return redirect('fuel/list');
    }

    public function cancel (Request $req) {
        $fuel = VehicleFuel::find($req['_id']);
        $fuel->status = '3';
        var_dump($fuel);

        if ($fuel->save()) {
            return redirect('fuel/list');
        // } else {
        //     return redirect()->back()->with('success', ['your message,here']);
        }
    }
}
