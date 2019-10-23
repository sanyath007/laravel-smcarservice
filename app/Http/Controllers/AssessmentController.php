<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index ()
    {

    }

    public function create ()
    {
        return view('assessments.newform');
    }

    public function store (Request $req)
    {
        // print_r($req->shifts);
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

        // if ($assign->save()) {
            $assignreserve = AssignmentReserve::where(['assign_id' => $req['assid']])->get();

            foreach ($assignreserve as $ar) {
                print_r($ar);
        //         // $ar->times = $req['times'];
        //         // $ar->save();

        /** 
         * Reserve status 
         * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
         */
        //         $reserve = Reservation::find($ar->reserve_id);
        //         $reserve->vehicle_id = $req['vehicle'];
        //         $reserve->driver_id = $req['driver'];
        //         $reserve->save();
            }
            
        //     return redirect('/assign/edit');
        // } else {
        //     return redirect('/assign/edit');
        // }

    }

    public function delete ($id) 
    {
        $assignment = Assignment::find($id)->delete();
        return redirect('assign/list');
    }

    public function drive () 
    {
        $assignments = Assignment::orderBy('id','DESC')->paginate(10);

        return view('assignments.drive', [
            'assignments' => $assignments,
        ]);
    }

    public function sendmail ()
    {
        $verify_code = str_random(30);
        \Mail::send('email.verify', ['verify_code' => $verify_code], function ($message) {
            $message->to('sanyath007@gmail.com', 'Sanya Thammawong')
                    ->subject('Please assessment.');
        });

        return redirect('assess/new');
    }

    public function verify ()
    {

    }
}
