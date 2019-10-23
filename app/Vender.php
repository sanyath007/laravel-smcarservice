<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vender extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'venders';

  	public function vehicle()
    {
        return $this->hasMany('App\Vehicle', 'vender_id', 'vender_id');
    }
}
