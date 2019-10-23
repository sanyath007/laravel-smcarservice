<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Location;
use App\Changwat;
use App\Amphur;
use App\Tambon;

class LocationController extends Controller
{
    public function ajaxquery ($location)
    {
        if(empty($location)){
            $locations = Location::where('id', '<>', '1')->get();
        }else{
            $locations = Location::where('name', 'like', '%' .$location. '%')
                                    ->where('id', '<>', '1')
                                    ->get();
        }

        return $locations;
    }

    public function ajaxlocation ($id)
    {
        return Location::find($id);
    }

    public function ajaxchangwat ()
    {
        return Changwat::all();
    }

    public function ajaxamphur ($chwid)
    {
        return Amphur::where(['chw_id' => $chwid])->get();
    }

    public function ajaxtambon ($ampid)
    {
        return Tambon::where(['amp_id' => $ampid])->get();
    }

    public function ajaxadd (Request $req)
    {
        $newlocation = new Location();
        $newlocation->name = $req->name;
        $newlocation->type = $req->type;
        $newlocation->address = $req->address;
        $newlocation->road = $req->road;
        $newlocation->changwat = $req->changwat;
        $newlocation->amphur = $req->amphur;
        $newlocation->tambon = $req->tambon;
        $newlocation->postcode = $req->postcode;

        if ($newlocation->save()) {
            return [
                'msg' => 'Successfully',
            ];
        } else {
            return [
                'msg' => 'Unsuccessfully !!!',
            ];
        }   
    }
}
