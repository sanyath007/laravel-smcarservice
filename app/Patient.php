<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  	protected $connection = 'hosxp';

  	protected $table = 'patient';
  
  	public function operation()
  	{
      	return $this->hasMany('App\OperationList', 'hn', 'hn');
  	}

  	public function referout()
  	{
      	return $this->hasMany('App\ReferOut', 'hn', 'hn');
  	}
}
