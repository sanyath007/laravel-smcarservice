<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\ReservePassenger;
use App\Maintenance;
use App\Vehicle;
use App\Driver;
use App\Location;
use App\Department;
use App\Ward;
use App\Assignment;
use App\AssignmentReserve;

class ReportController extends Controller
{
	public function reserve () {
        return view('reports.reservation', [
            'vehicles' => Vehicle::where(['status' => '1'])
                                ->with('cate')
                                ->with('type')
                                ->with('method')
                                ->with('manufacturer')
                                ->with('changwat')
                                ->with('vender')
                                ->with('fuel')
                                ->paginate(10),
            'reservations' => Reservation::with('user')
                                ->orderBy('id', 'DESC')
                                // ->orderBy('from_date', 'DESC')
                                // ->orderBy('reserve_date', 'ASC')
                                ->paginate(10)
        ]);
    }
    public function drive () 
    {
    	$assignments = Assignment::orderBy('id','DESC')->paginate(10);

    	return view('reports.drive', [
    		'assignments' => $assignments,
    	]);
    }

    public function service ()
    {
        return view('reports.service', [
            'assignments' => Assignment::orderBy('id','DESC')->paginate(10),
        ]);
    }
    
    public function serviceChart ($month)
    {
        $sdate = $month . '-01';
        $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT CONCAT(YEAR(reserve_date), MONTH(reserve_date)) as 'month',
                COUNT(DISTINCT id) as request,
                COUNT(DISTINCT(CASE WHEN (status <> 5) THEN id END)) as service,
                COUNT(DISTINCT(CASE WHEN (status = 5) THEN id END)) as cancel
                FROM reservations
                WHERE (reserve_date BETWEEN '2017-10-01' AND '2018-09-30')
                GROUP BY CONCAT(YEAR(reserve_date), MONTH(reserve_date))
                ORDER BY CONCAT(YEAR(reserve_date), MONTH(reserve_date))";

        return \DB::select($sql);
    }

    public function period ()
    {
        return view('reports.period', [
            'assignments' => Assignment::orderBy('id','DESC')->paginate(10),
        ]);
    }
    
    public function periodChart ($month)
    {
        $sdate = $month . '-01';
        $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT from_date AS reserv_date, DAY(from_date) AS d, 
                COUNT(DISTINCT(CASE WHEN (from_time BETWEEN '00:00:01' AND '07:59:59') THEN id END)) as n,
                COUNT(DISTINCT(CASE WHEN (from_time BETWEEN '08:00:00' AND '12:59:59') THEN id END)) as m,
                COUNT(DISTINCT(CASE WHEN (from_time BETWEEN '13:00:00' AND '15:59:59') THEN id END)) as a,
                COUNT(DISTINCT(CASE WHEN (from_time BETWEEN '16:00:00' AND '23:59:59') THEN id END)) as e
                FROM reservations
                WHERE (from_date BETWEEN '$sdate' AND '$edate')
                AND (status <> 5)
                GROUP BY from_date
                ORDER BY from_date ";

        return \DB::select($sql);
    }

    public function depart ()
    {
        return view('reports.depart', [
            'assignments' => Assignment::orderBy('id','DESC')->paginate(10),
        ]);
    }
    
    public function departChart ($month)
    {
        $sdate = $month . '-01';
        $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT CONCAT(d.depart_name) as depart,
                COUNT(DISTINCT r.id) as request,
                COUNT(DISTINCT(CASE WHEN (r.status <> 5) THEN r.id END)) as service,
                COUNT(DISTINCT(CASE WHEN (r.status = 5) THEN r.id END)) as cancel
                FROM vehicle_db.reservations r LEFT JOIN db_ksh.depart d ON (r.department=d.depart_id)
                WHERE (r.reserve_date BETWEEN '$sdate' AND '$edate')
                GROUP BY CONCAT(r.department,'-',d.depart_name) 
                ORDER BY COUNT(DISTINCT r.id) DESC 
                LIMIT 10 ";

        return \DB::select($sql);
    }

    public function refer ()
    {
        return view('reports.refer', [
            'assignments' => Assignment::orderBy('id','DESC')->paginate(10),
        ]);
    }
    
    public function referChart ($month)
    {
        $sdate = $month . '-01';
        $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT refer_date, DAY(refer_date) AS d, 
                COUNT(DISTINCT referout_id) AS total,
                COUNT(DISTINCT CASE WHEN (refer_time BETWEEN '00:00:01' AND '07:59:59') THEN referout_id END) AS n,
                COUNT(DISTINCT CASE WHEN (refer_time BETWEEN '08:00:00' AND '15:59:59') THEN referout_id END) AS m,
                COUNT(DISTINCT CASE WHEN (refer_time BETWEEN '16:00:00' AND '23:59:59') THEN referout_id END) AS a
                FROM referout 
                WHERE (refer_date BETWEEN '$sdate' AND '$edate')
                AND (with_ambulance='Y')
                GROUP BY refer_date
                ORDER BY refer_date";

        return \DB::connection('hosxp')->select($sql);
    }

    public function fuelDay ()
    {
        return view('reports.fuel-day', [
            'assignments' => Assignment::orderBy('id','DESC')->paginate(10),
        ]);
    }
    
    public function fuelDayChart ($month)
    {
        $sdate = $month . '-01';
        $edate = date("Y-m-t", strtotime($sdate));

        $sql = "SELECT bill_date, SUM(volume) as qty, SUM(total) as net 
                FROM vehicle_fuel f LEFT JOIN vehicles v ON (f.vehicle_id=v.vehicle_id)
                WHERE (bill_date BETWEEN '$sdate' AND '$edate')
                GROUP BY bill_date
                ORDER BY bill_date";

        return \DB::select($sql);
    }
}
