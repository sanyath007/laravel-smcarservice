<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferOut extends Model
{
  	protected $connection = 'hosxp';

  	protected $table = 'referout';

  	public function patient()
  	{
      	return $this->belongsTo('App\VnStat', 'vn', 'vn');
  	}  

  	public function vn()
  	{
      	return $this->belongsTo('App\VnStat', 'vn', 'vn');
  	} 
}
