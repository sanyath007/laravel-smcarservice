<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
  	protected $connection = 'vehicle';
  	protected $table = 'insurance_types';

    public function insurance()
    {
        return $this->hasMany('App\insurance', 'insurance_type_id', 'insurance_type');
    }
}
