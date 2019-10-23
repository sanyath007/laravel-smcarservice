<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'fuel_type';

  	public function vehicle()
    {
        return $this->hasMany('App\Vehicle', 'fuel_type', 'fuel_type_id');
    }

    public function fuel_used()
    {
        return $this->belongsTo('App\VehicleFuel', 'fuel_type_id', 'fuel_type_id');
    }
}
