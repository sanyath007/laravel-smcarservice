<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDailyCheck extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'vehicle_dailycheck';

  	public function user()
    {
        return $this->hasMany('App\User', 'user_id', 'person_id');
    }

    public function vehicle()
    {
        return $this->hasMany('App\Vehicle', 'vehicle_id', 'vehicle_id');
    }
}
