<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleFuel extends Model
{
    protected $connection = 'vehicle';
  	protected $table = 'vehicle_fuel';

  	public function vehicle()
    {
        return $this->hasMany('App\Vehicle', 'vehicle_id', 'vehicle_id');
    }

    public function fuel_type()
    {
        return $this->hasMany('App\FuelType', 'fuel_type_id', 'fuel_type_id');
    }
}
