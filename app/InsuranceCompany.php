<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'insurance_companies';

    public function insurance()
    {
        return $this->hasMany('App\Insurance', 'insurance_company_id', 'insurance_company_id');
    }
}
