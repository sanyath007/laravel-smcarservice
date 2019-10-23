<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
    public function ajaxperson ($name) {
        if(empty($name)){
            $persons = User::with('position')->with('department')->all();
        }else{
            $fullname = explode(' ', $name);

            if (count($fullname) > 1) {
                $persons = User::where('person_firstname', 'like', '%' .$fullname[0]. '%')
                            ->where('person_lastname', 'like', '%' .$fullname[1]. '%')
                            ->with('position')
                            ->with('ward')
                            ->get();
            } else {
                $persons = User::where('person_firstname', 'like', '%' .$name. '%')
                            ->with('position')
                            ->with('ward')
                            ->get();
            }
        }

        $users = [];
        foreach ($persons as $person) {
            array_push($users, [
                'id' => $person->person_id,
                'name' => $person->person_firstname. ' ' .$person->person_lastname,
                'position' => $person->position->position_name,
                'ward' => $person->ward->ward_name,
            ]);
        }

        return $users;
    }
}
