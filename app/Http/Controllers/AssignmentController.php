<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Assignment;
use App\AssignmentReserve;
use App\Reservation;
use App\Vehicle;
use App\Location;
use App\User;

class AssignmentController extends Controller
{
    public function index ()
    {
        $date = new \DateTime(date('Y-m-d'));
        $fromdate = Input::get('fromdate');

    	if ($fromdate != '') {
            $assignments = Assignment::where('depart_date', '=', $fromdate)
                                    ->with('assignreserve')
                                    ->orderBy('depart_date', 'DESC')
                                    ->orderBy('depart_time', 'DESC')
                                    ->paginate(10);
        } else {
            $assignments = Assignment::with('assignreserve')
                                    ->orderBy('depart_date', 'DESC')
                                    ->orderBy('depart_time', 'DESC')
                                    ->paginate(10);
        }
    	
        $count_not_assigned = Reservation::where('from_date', '>', '2017-10-15')
                                    ->whereIn('status', ['0','1','3'])
                                    ->count();

        $count_canceled = Reservation::where('from_date', '>', '2017-10-15')
                                    ->where('status', '=', '5')
                                    ->count();

    	return view('assignments.list', [
    		'assignments' => $assignments,
            'vehicles' => DB::table("vehicle_db.vehicles")->select('*')
                                ->join('vehicle_db.vehicle_cates', 'vehicle_db.vehicles.vehicle_cate', '=', 'vehicle_cates.vehicle_cate_id')
                                ->join('vehicle_db.vehicle_types', 'vehicle_db.vehicles.vehicle_type', '=', 'vehicle_db.vehicle_types.vehicle_type_id')
                                ->join('vehicle_db.manufacturers', 'vehicle_db.vehicles.manufacturer_id', '=', 'vehicle_db.manufacturers.manufacturer_id')
                                ->where(['status' => '1'])
                                // ->whereNOTIn('vehicle_id', function ($query) use ($date) {
                                //     $query->select('vehicle_id')
                                //             ->from('vehicle_db.assignments')
                                //             ->whereDate('depart_date', '=', $date);
                                //             // ->where('shift', '=', $shift);
                                // })                              
                                // ->with('method')
                                // ->with('manufacturer')
                                // ->with('changwat')
                                // ->with('vender')
                                // ->with('fuel')
                                ->get(),
            'drivers' => DB::table("vehicle_db.drivers")->select('*')
                                // ->whereNOTIn('driver_id', function ($query) use ($date) {
                                //     $query->select('driver_id')
                                //             ->from('vehicle_db.assignments')
                                //             ->whereDate('depart_date', '=', $date);
                                //             // ->where('shift', '=', $shift);
                                // })
                                ->get(),
            'count_not_assigned'   => $count_not_assigned,
            'count_canceled'       => $count_canceled,
            'fromdate'            => $fromdate,
    	]);
    }

    public function create ()
    {
    	return view('assignments.newform');
    }

    public function store (Request $req)
    {
    	$d = new \DateTime(date('Y-m-d H:i:s'));
        $diffHours = new \DateInterval('PT7H');

    	$assign = new Assignment();
    	$assign->assign_date = $d->add($diffHours);
    	$assign->depart_date = $req['depart_date'];
    	$assign->depart_time = $req['depart_time'];
    	$assign->vehicle_id = $req['vehicle'];
    	$assign->driver_id = $req['driver'];
    	$assign->shift = $req['shifts'];
    	$assign->allday = $req['allday'];
        $assign->status = $req['status'];
    	$assign->created_user = \Auth::user()->person_id; //ผู้บันทึกจัดรถ
    	
    	if ($assign->save()) {
    		$assignLastId = $assign->id;

    		foreach ($req->reservations as $r) {
    			$ar = new AssignmentReserve();
    			$ar->assign_id = $assignLastId;
                $ar->reserve_id = $r;
    			$ar->times = $req['times'];
    			$ar->save();

                /** 
                 * Reserve status
                 * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
                 */
    			$reserve = Reservation::find($r);
    			$reserve->vehicle_id = $req['vehicle'];
    			$reserve->driver_id = $req['driver'];
    			$reserve->status = ($req['status'] == 1) ? 2 : ($req['times'] == 2) ? 2 : 3;
    			$reserve->save();
    		}
    		
    		return redirect('/assign/new')->with('status', 'บันทึกข้อมูลเรียบร้อย');
    	} else {
    		return redirect('/assign/new')->with('status', 'พบข้อผิดพลาด');
    	}
    }

    public function edit ($id, $date, $shift)
    {
        return view('assignments.editform', [
            'assignment' => Assignment::where(['id' => $id])->with('assignreserve')->get(),
            'vehicles' => DB::table("vehicle_db.vehicles")->select('*')
                                ->join('vehicle_db.vehicle_cates', 'vehicle_db.vehicles.vehicle_cate', '=', 'vehicle_cates.vehicle_cate_id')
                                ->join('vehicle_db.vehicle_types', 'vehicle_db.vehicles.vehicle_type', '=', 'vehicle_db.vehicle_types.vehicle_type_id')
                                ->join('vehicle_db.manufacturers', 'vehicle_db.vehicles.manufacturer_id', '=', 'vehicle_db.manufacturers.manufacturer_id')
                                ->where(['status' => '1'])
                                // ->whereNOTIn('vehicle_id', function ($query) use ($date, $shift) {
                                //     $query->select('vehicle_id')
                                //             ->from('vehicle_db.assignments')
                                //             ->whereDate('depart_date', '=', $date)
                                //             ->where('shift', '=', $shift);
                                // })
                                ->get(),
            'drivers' => DB::table("vehicle_db.drivers")->select('*')
                                // ->whereNOTIn('driver_id', function ($query) use ($date, $shift) {
                                //     $query->select('driver_id')
                                //             ->from('vehicle_db.assignments')
                                //             ->whereDate('depart_date', '=', $date)
                                //             ->where('shift', '=', $shift);
                                // })
                                ->get(),
        ]);
    }

    public function update (Request $req)
    {
        $assign = Assignment::find($req['assid']);
        $assign->depart_date = $req['depart_date'];
        $assign->depart_time = $req['depart_time'];
        $assign->vehicle_id = $req['vehicle'];
        $assign->driver_id = $req['driver'];
        $assign->shift = $req['shifts'];
        $assign->allday = $req['allday'];
        $assign->status = $req['status'];

        if ($assign->save()) {
            $assignreserve = AssignmentReserve::where(['assign_id' => $req['assid']])->get();

            foreach ($assignreserve as $ar) {
                print_r($ar);
        //         // $ar->times = $req['times'];
        //         // $ar->save();

        /** 
         * Reserve status 
         * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
         */
                $reserve = Reservation::find($ar->reserve_id);
                $reserve->vehicle_id = $req['vehicle'];
                $reserve->driver_id = $req['driver'];
                $reserve->save();
            }
            
            return redirect('/assign/edit');
        } else {
            return redirect('/assign/edit');
        }

    }

    public function delete ($id) 
    {
        $assignment = Assignment::find($id)->delete();
        return redirect('assign/list');
    }

    public function drive () 
    {
        $fromdate = Input::get('fromdate');

        if ($fromdate != '') {
            $assignments = Assignment::where('depart_date', '=', $fromdate)
                                    ->with('assignreserve')
                                    ->orderBy('depart_date', 'DESC')
                                    ->orderBy('depart_time', 'DESC')
                                    ->paginate(10);
        } else {
            $assignments = Assignment::with('assignreserve')
                                    ->orderBy('depart_date', 'DESC')
                                    ->orderBy('depart_time', 'DESC')
                                    ->paginate(10);
        }

    	return view('assignments.drive', [
    		'assignments'   => $assignments,
            'fromdate'      => $fromdate,
    	]);
    }

    public function drivedeparted (Request $req)
    {
        $d = new \DateTime(date('Y-m-d H:i:s'));
        $diffHours = new \DateInterval('PT7H');

        $dateFromUser = $req['_date']. ' ' .$req['_time'];

        $assignment = Assignment::find($req['id']);
        // $assignment->start_time = $d->add($diffHours);
        $assignment->start_time = $dateFromUser;
        $assignment->start_mileage = $req['mileage'];
        $assignment->save();

        if ($assignment->save()) {
            $vehicle = Vehicle::where(['vehicle_id' => $assignment->vehicle_id])->first();
            $vehicle->current_mileage = $req['mileage'];
            $vehicle->save();
        }

        return redirect('assign/drive');
    }

    public function drivearrived (Request $req)
    {
        $d = new \DateTime(date('Y-m-d H:i:s'));
        $diffHours = new \DateInterval('PT7H');
        $dateFromUser = $req['_date']. ' ' .$req['_time'];

        $assignment = Assignment::find($req['id']);
        // $assignment->end_time = $d->add($diffHours);
        $assignment->end_time = $dateFromUser;
        $assignment->end_mileage = $req['mileage'];

        if ($assignment->save()) {
            $vehicle = Vehicle::where(['vehicle_id' => $assignment->vehicle_id])->first();
            $vehicle->current_mileage = $req['mileage'];
            $vehicle->save();
        }

        return redirect('assign/drive');
    }

    public function ajaxstartmileage ($id) 
    {
        return $startMileage = Assignment::find($id)->start_mileage;
    }

    public function ajaxassign ($date, $shift) 
    {
        if ($shift == 1) {
            $start = '00:00:01';
            $end = '12:00:00';
        } else if ($shift == 2) {
            $start = '12:00:01';
            $end = '23:59:59';
        }

        /** 
         * Reserve status 
         * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
         */
        $reservations = Reservation::where(function ($query) use ($date) {
                                        $query->where(['from_date' => $date])
                                              ->orWhere(function ($subquery) use ($date) {
                                                $subquery->where(['to_date' => $date])
                                                         ->where(['transport' => '6']);
                                              });
                                        })
                                    ->whereBetween('from_time', [$start, $end])
                                    ->whereIn('status', ['0','1','3'])
                                    ->orderBy('from_time', 'ASC')
                                    ->get();

        foreach ($reservations as $r) {
	        $locations = '';
	        $arrLocations = explode(',', $r->location);
            
	        if (count($arrLocations) > 0) {
	        	$index = 0;
	        	foreach ($arrLocations as $key) {
	        		$l = Location::find($key);

	        		if ($index < count($arrLocations) - 1) {
		        		$locations .= $l->id. '-' .$l->name. ', ';
	        		} else {
		        		$locations .= $l->id. '-' .$l->name;
	        		}

		        	$index++;
	        	}
	        } else {
	        	$l = Location::find($r->location);
		        $locations .= $l->id. '-' .$l->name. ', ';
	        }

        	$user = User::where(['person_id' => $r->user_id])->first();
        	$r->user = $user->person_firstname. '  ' .$user->person_lastname. ' / ' .$user->person_tel;
        	$r->locations = $locations;
    	}

        return [
        	'reservations' => $reservations,
        	'vehicles' => DB::table("vehicle_db.vehicles")->select('*')
        						->join('vehicle_db.vehicle_cates', 'vehicle_db.vehicles.vehicle_cate', '=', 'vehicle_cates.vehicle_cate_id')
                                ->join('vehicle_db.vehicle_types', 'vehicle_db.vehicles.vehicle_type', '=', 'vehicle_db.vehicle_types.vehicle_type_id')
                                ->join('vehicle_db.manufacturers', 'vehicle_db.vehicles.manufacturer_id', '=', 'vehicle_db.manufacturers.manufacturer_id')
        						->where(['status' => '1'])
					            // ->whereNOTIn('vehicle_id', function ($query) use ($date, $shift) {
					            //    	$query->select('vehicle_id')
					            //    			->from('vehicle_db.assignments');
					            //    			->whereDate('depart_date', '=', $date)
					            //    			->where('shift', '=', $shift)
                 //                            ->where('status','<>','2');
					            // })					            
                                // ->with('method')
                                // ->with('manufacturer')
                                // ->with('changwat')
                                // ->with('vender')
                                // ->with('fuel')
					            ->get(),
			'drivers' => DB::table("vehicle_db.drivers")->select('*')
					            // ->whereNOTIn('driver_id', function ($query) use ($date, $shift) {
					            //    	$query->select('driver_id')
					            //    			->from('vehicle_db.assignments');
					               			// ->whereDate('depart_date', '=', $date)
					               			// ->where('shift','=', $shift)
                       //                      ->where('status','<>','2');
					            // })
					            ->get(),
       	];
    }

    public function ajaxchange (Request $req) {
        $assign = Assignment::find($req['assignid']);
        $assign->driver_id = $req['driver'];
        $assign->vehicle_id = $req['vehicle'];

        if ($assign->save()) {
            $assignreserve = AssignmentReserve::where(['assign_id' => $req['assignid']])->get();

            foreach ($assignreserve as $ar) {
                /** 
                 * Reserve status 
                 * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
                 */
                $reserve = Reservation::find($ar->reserve_id);
                $reserve->vehicle_id = $req['vehicle'];
                $reserve->driver_id = $req['driver'];
                $reserve->save();
            }
        }

        return redirect('assign/list')->with('status', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function ajaxadd_reservation (Request $req)
    {
        $ar = new AssignmentReserve();
        $ar->assign_id = $req['assign_id'];
        $ar->reserve_id = $req['reserve_id'];
        $ar->times = $req['times'];
        
        if($ar->save()) {
            /** 
             * Reserve status 
             * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
             */
            // $reserve = Reservation::find($ar->reserve_id);
            // $reserve->vehicle_id = $req['vehicle'];
            // $reserve->driver_id = $req['driver'];
            // $reserve->save();
            return [
                'msg' => 'Successfully'
            ];
        } else {
            return [
                'msg' => 'Failure'
            ];
        }
    }
}
