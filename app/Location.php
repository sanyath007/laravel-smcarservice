<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'locations';

  	// public function user()
   //  {
   //      return $this->hasMany('App\User', 'position_id', 'position_id');
   //  }
}
