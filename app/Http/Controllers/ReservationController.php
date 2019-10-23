<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Input;
use App\Http\Requests;

use App\Reservation;
use App\ReservePassenger;
use App\Maintenance;
use App\Vehicle;
use App\Models\Driver;
use App\Location;
use App\Department;
use App\Ward;
use App\Position;

class ReservationController extends Controller
{

	public function __construct () 
	{
		// $this->middleware('auth');
	}

    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'activity_type' => 'required',
            'activity' => 'required',
            'location' => 'required',
            'department' => 'required',
            // 'ward' => 'required',
            'transport' => 'required',
            // 'startpoint' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        } else {
            return [
                'success' => 1,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        }
    }

	public function index (Request $req) {
        $searchdate = $req->input('searchdate');

        $activityType = [
            "1"     => "ประชุม/อบรม/สัมมนา/ร่วมกิจกรรม",
            "2"     => "ศึกษาดูงาน",
            "18"    => "รับ/ส่ง ผู้ป่วย",
            "3"     => "รับ/ส่ง จนท./วิทยากร/ผู้เข้าประชุมหรืออบรม",
            "4"     => "รับ/ส่ง เอกสาร/หนังสือ/จดหมาย ทางราชการ",
            "5"     => "รับ/ส่ง ยา/เวชภัณฑ์",
            "19"    => "รับ/ส่ง วัสดุทางการแพทย์/เลือด/Specimen/LAB ฯลฯ",
            "6"     => "รับ/ส่ง ครุภัณฑ์/อุปกรณ์/เครื่องมือ ฯลฯ",
            "7"     => "ออกหน่วยปฐมพยาบาล",
            "8"     => "เยี่ยมผู้ป่วย",
            "9"     => "ให้บริการภายนอก รพ.",
            "10"    => "ทำธุรกรรมที่ธนาคาร",
            "11"    => "ซื้อของ",
            "12"    => "ควบคุม/สอบสวนโรค",
            "13"    => "ตรวจราชการ/ประเมินผลงาน",
            "14"    => "รับบริจาค",
            "15"    => "ดูสถานที่จัดประชุม/กิจกรรม",
            "16"    => "ร่วมงานศพ",
            "17"    => "ร่วมงานแต่งงาน",
            "99"    => "อื่นๆ",
        ];

        if ($searchdate != '') {
            $reservations = Reservation::where('from_date', '=', $searchdate)
                                ->with('user')
                                // ->orderBy('id', 'DESC')
                                // ->orderBy('from_date', 'DESC')
                                ->orderBy('reserve_date', 'DESC')
                                ->paginate(10);
        } else {
            $reservations = Reservation::with('user')
                                // ->orderBy('id', 'DESC')
                                // ->orderBy('from_date', 'DESC')
                                ->orderBy('reserve_date', 'DESC')
                                ->paginate(10);
        }

        return view('reservations.list', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'reservations'  => $reservations,
            'activityType'  => $activityType,
            'searchdate'    => $searchdate,
        ]);
    }

    public function create () {
        return view('reservations.newform', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'maintenances' => Maintenance::with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->paginate(10),
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    public function store (Request $request)
    {
        // var_dump($request);
        $d = new \DateTime(date('Y-m-d H:i:s'));
        $diffHours = new \DateInterval('PT7H');

        // Calculate passenger amount
        // $passengers = explode(',', $request['passengers']);
        // $passengerCount = ($passengers[0] != '') ? count($passengers) + 1 : count($passengers);

        // Upload attach file
        // var_dump($request->file('attachfile'));
        // $filename = '';
        // if ($file = $request->file('attachfile')) {
        //     $filename = $file->getClientOriginalName();
        //     $file->move('uploads', $filename);
        // }

        $reserve = new Reservation();
        $reserve->reserve_date = $d->add($diffHours);
        $reserve->reserve_type = $request['reserve_type'];
        $reserve->reserve_type_text = $request['reserve_type_text'];

        $reserve->user_id = $request['user'];
        $reserve->department = $request['department'];
        // $reserve->ward = $request['ward'];

        $reserve->reserve_user = $request['reserve_user'];
        $reserve->reserve_user_position = $request['reserve_user_position'];
        $reserve->reserve_user_tel = $request['reserve_user_tel'];

        $reserve->activity_type = $request['activity_type'];
        $reserve->activity = $request['activity'];
        $reserve->location = $request['location'];
        $reserve->passengers = $request['passengerNum'];
        $reserve->from_date = $request['from_date'];
        $reserve->from_time = $request['from_time'];
        $reserve->to_date = $request['to_date'];
        $reserve->to_time = $request['to_time'];
        $reserve->transport = $request['transport'];
        $reserve->startpoint = $request['startpoint'];
        // $reserve->attachfile = $filename;
        $reserve->vehicle_type = $request['vehicle_type'];
        $reserve->remark = $request['remark'];
        $reserve->approved = '0';
        $reserve->status = '0'; //0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก

        if ($reserve->save()) {
            // $reserveLastId = $reserve->id;
            
            //add user to passengers
            // if ($request['chkUserIn'] == 'on') {
            //     $newPassenger = new ReservePassenger();
            //     $newPassenger->reserve_id = $reserveLastId;
            //     $newPassenger->person_id = $request['user'];
            //     $newPassenger->status = '1';
            //     $newPassenger->save();
            // }

            // if ($passengers[0] != '') {
            //     foreach ($passengers as $key => $value) {
            //         $newPassenger = new ReservePassenger();
            //         $newPassenger->reserve_id = $reserveLastId;
            //         $newPassenger->person_id = $value;
            //         $newPassenger->status = '2';
            //         $newPassenger->save();
            //     }
            // }

            return redirect('reserve/list');
        } else {
            return view('reservations.newform', [
                'vehicles' => Vehicle::where(['status' => '1'])
                                    ->with('cate')
                                    ->with('type')
                                    ->with('method')
                                    ->with('manufacturer')
                                    ->with('changwat')
                                    ->with('vender')
                                    ->with('fuel')
                                    ->paginate(10),
                'maintenances' => Maintenance::with('vehicle')
                                    ->with('garage')
                                    ->with('user')
                                    ->paginate(10)
            ]);
    	}
    }

    public function edit ($id) {
        return view('reservations.editform', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'reservation' => Reservation::where(['id' => $id])
                                ->with('vehicle')
                                ->with('user')
                                ->first(),
        ]);
    }

    public function update(Request $req, $id) 
    {
        $reservation = Reservation::find($id);
        $reservation->user_id = $req['user'];
        $reservation->department = $req['department'];
        $reservation->ward = $req['ward'];
        $reservation->activity_type = $req['activity_type'];
        $reservation->activity = $req['activity'];
        $reservation->location = $req['location'];
        $reservation->passengers = $req['passengerNum'];
        $reservation->from_date = $req['from_date'];
        $reservation->from_time = $req['from_time'];
        $reservation->to_date = $req['to_date'];
        $reservation->to_time = $req['to_time'];
        $reservation->transport = $req['transport'];
        $reservation->startpoint = $req['startpoint'];
        // $reservation->attachfile = $filename;
        $reservation->remark = $req['remark'];
        $reservation->approved = '0';        
        $reservation->status = '0'; //0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
        print_r($reservation);

        if ($reservation->save()) {
            return redirect('reserve/list');
        } else {
            return redirect()->back()->with('success', ['your message,here']);
        }
    }

    public function delete (Request $req) 
    {
        $reservation = Reservation::find($req['_id'])->delete();
        return redirect('reserve/list');
    }

    public function cancel (Request $req) {
        $reservation = Reservation::find($req['_id']);
        $reservation->approved = '0';
        $reservation->status = '5';
        var_dump($reservation);

        if ($reservation->save()) {
            return redirect('reserve/list');
        // } else {
        //     return redirect()->back()->with('success', ['your message,here']);
        }
    }

    public function recover (Request $req) {
        $reservation = Reservation::find($req['_id']);
        $reservation->approved = '0';
        $reservation->status = '0';
        var_dump($reservation);

        // if ($reservation->save()) {
        //     return redirect('reserve/list');
        // // } else {
        // //     return redirect()->back()->with('success', ['your message,here']);
        // }
    }

    public function ajaxdetail ($id) {
        $activityType = [
            "1"     => "ประชุม/อบรม/สัมมนา/ร่วมกิจกรรม",
            "2"     => "ศึกษาดูงาน",
            "18"    => "รับ/ส่ง ผู้ป่วย",
            "3"     => "รับ/ส่ง จนท./วิทยากร/ผู้เข้าประชุมหรืออบรม",
            "4"     => "รับ/ส่ง เอกสาร/หนังสือ/จดหมาย ทางราชการ",
            "5"     => "รับ/ส่ง ยา/เวชภัณฑ์",
            "19"    => "รับ/ส่ง วัสดุทางการแพทย์/เลือด/Specimen/LAB ฯลฯ",
            "6"     => "รับ/ส่ง ครุภัณฑ์/อุปกรณ์/เครื่องมือ ฯลฯ",
            "7"     => "ออกหน่วยปฐมพยาบาล",
            "8"     => "เยี่ยมผู้ป่วย",
            "9"     => "ให้บริการภายนอก รพ.",
            "10"    => "ทำธุรกรรมที่ธนาคาร",
            "11"    => "ซื้อของ",
            "12"    => "ควบคุม/สอบสวนโรค",
            "13"    => "ตรวจราชการ/ประเมินผลงาน",
            "14"    => "รับบริจาค",
            "15"    => "ดูสถานที่จัดประชุม/กิจกรรม",
            "16"    => "ร่วมงานศพ",
            "17"    => "ร่วมงานแต่งงาน",
            "99"    => "อื่นๆ",
        ];

        $transport = [
            "1"     => "ส่งอย่างเดียว",
            "2"     => "รับอย่างเดียว",
            "3"     => "รับ-ส่ง (ภายในวัน)",
            "5"     => "รับ-ส่ง (โดยส่งไว้ แล้วไปรับเวลากลับ)",
            "4"     => "รับ-ส่ง (ต้องค้างคืน)",
            "6"     => "รับ-ส่ง (ทุกวัน กรณีไปหลายวัน โดยเวลาและสถานที่เดียวกัน)",
            "9"     => "ขับเอง (เฉพาะกรณีผู้ขอเป็นพนักงานขับรถสำรอง)",
        ];

        return [
            'vehicles'      => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'reservation'   => Reservation::where(['id' => $id])
                                ->with('user')
                                ->first(),
            'activityType'  => $activityType,
            'transport'     => $transport,
        ];
    }

    public function calendar () {
        return view('reservations.calendar', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'maintenances' => Maintenance::with('vehicle')
                                ->with('garage')
                                ->with('user')
                                ->paginate(10),
        ]);
    }

    public function ajaxcalendar ($sdate, $edate) {
        /** 
         * Reserve status 
         * 0=ยังไม่เปิดดู,1=รับเรื่องแล้ว,2=อนุมัติแล้ว,3=เหลืออีกเที่ยว,4=จบงาน,5=ยกเลิก
         */
        $events = [];
        $reservations = Reservation::whereBetween('from_date', [$sdate, $edate])
                                ->whereIn('status', ['0','1','2','3'])
                                ->with('vehicle')
                                ->with('driver')
                                ->with('user')
                                ->get();

        foreach ($reservations as $reserve) {
            // $locationsText = '';
            // $locationsIndex = explode(',', $reserve->location);

            // foreach ($locationsIndex as $l) {
            //     $locations = Location::where(['id' => $l])->first();
            //     $locationsText .= $locations->name. ', '; 
            // }
             
            $event = [
                'id'    => $reserve->id,
                'title' => $reserve->activity. ' ณ ' .$reserve->location. 'จำนวน ' .$reserve->passengers. ' ราย',
                'start' => $reserve->from_date. 'T' .$reserve->from_time,
                'end'   => $reserve->to_date. 'T' .$reserve->to_time,
                'color' => ($reserve->reserve_type == '2') ? 'red' : 'green',
            ];

            array_push($events, $event);
        }

        return $events;
    }

    public function ajaxward ($department) {
        return Ward::where(['depart_id' => $department])->get();
    }

    public function ajaxedit ($id) {
        $reservation = Reservation::where(['id' => $id])
                                ->with('vehicle')
                                ->with('user')
                                ->first();

        return [
            $reservation,
            Ward::where(['depart_id' => $reservation->department])->get(),
        ];
    }

    public function ajaxshift ($date, $shift) {
        if ($shift == 1) {
            $start = '08:00:00';
            $end = '12:00:00';
        } else if ($shift == 2) {
            $start = '12:00:01';
            $end = '16:00:00';
        } else if ($shift == 3) {

        }

        return Reservation::where(['from_date' => $date])
                            ->whereBetween('from_time', [$start, $end])
                            ->orderBy('from_time', 'ASC')
                            ->get();
    }

    /*public function response (array $errors)
    {
        return Response::json([
            'error' => [
                'message' => $errors,
            ]
        ]);
    }*/
}
