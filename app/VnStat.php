<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VnStat extends Model
{
  	protected $connection = 'hosxp';

  	protected $table = 'vn_stat';

  	public function patient()
  	{
      	return $this->belongsTo('App\Patient', 'hn', 'hn');
  	}  

  	public function referout()
  	{
      	return $this->belongsTo('App\ReferOut', 'vn', 'vn');
  	}  

}
