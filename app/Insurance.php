<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'vehicle_insurances';

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', 'vehicle_id', 'vehicle_id');
    }

    public function company()
    {
        return $this->belongsTo('App\InsuranceCompany', 'insurance_company_id', 'insurance_company_id');
    }

    public function type()
    {
        return $this->belongsTo('App\InsuranceType', 'insurance_type', 'insurance_type_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo('App\User', 'user_id', 'person_id');
    // }
}
