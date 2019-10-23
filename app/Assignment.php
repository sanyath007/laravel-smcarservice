<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'assignments';

  	public function assignreserve()
    {
        return $this->hasMany('App\AssignmentReserve', 'assign_id', 'id');
    }
}
