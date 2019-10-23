<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'vehicle_taxes';

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', 'vehicle_id', 'vehicle_id');
    }

    // public function company()
    // {
    //     return $this->belongsTo('App\insurance', 'insurance_company_id', 'insurance_company_id');
    // }

    // public function type()
    // {
    //     return $this->belongsTo('App\insurance', 'insurance_type_id', 'insurance_type');
    // }

    // public function user()
    // {
    //     return $this->belongsTo('App\User', 'user_id', 'person_id');
    // }
}
