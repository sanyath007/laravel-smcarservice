<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentReserve extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'assignment_reserve';

  	public function assignment()
    {
        return $this->belongsTo('App\Assignment', 'assign_id', 'id');
    }
}
