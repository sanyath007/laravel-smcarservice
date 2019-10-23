<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $connection = 'person';

    protected $table = 'ward';

    public function reserve()
    {
        return $this->hasMany('App\Reservation', 'ward_id', 'ward');
    }
  
    public function user()
    {
        return $this->hasMany('App\User', 'ward_id', 'office_id');
    }
}
