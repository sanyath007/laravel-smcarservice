@extends('layouts.main')

@section('content')
<div class="container-fluid" ng-controller="assignCtrl">
  
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการจัดรถ</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            <i class="fa fa-calendar" aria-hidden="true"></i> รายการจัดรถ
        </span>
        <a href="{{ url('/assign/new') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            เพิ่มรายการ
        </a>
    </div>

    <hr />
    <!-- page title -->
    
    @if (session('status'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong>
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
        
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('/assign/list') }}" method="GET" class="form-inline">
                        <div class="form-group">
                            <label for="">วันที่เดินทาง :</label>
                            <input type="text" id="fromdate" name="fromdate" value="{{ $fromdate }}" class="form-control">
                        </div>

                        <button class="btn btn-primary">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            แสดงข้อมูล
                        </button>
                    </form>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <a class="btn btn-danger">
                        รายการรอจัดรถ  <span class="badge">{{ $count_not_assigned }}</span>
                    </a>

                    <a class="btn btn-default">
                        รายการยกเลิก  <span class="badge">{{ $count_canceled }}</span>
                    </a>
                </div>
            </div><br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 4%; text-align: center;">#</th>
                        <th style="width: 15%; text-align: center;">วันเดินทาง</th>
                        <th>รายละเอียดการขอใช้รถ</th>
                        <th style="width: 7%; text-align: center;">รถทะเบียน</th>
                        <th style="width: 12%; text-align: center;">พขร.</th>
                        <th style="width: 8%; text-align: center;">Actions</th>
                    </tr>

                    @foreach($assignments as $assignment)
                        <?php $vehicle = App\Vehicle::where(['vehicle_id' => $assignment->vehicle_id])->with('changwat')->first();
                        ?>

                        <?php $driver = App\Models\Driver::where(['driver_id' => $assignment->driver_id])->with('person')->first();
                        ?>
                    <tr>
                        <td style="text-align: center;">
                            <h4><span class="label label-<?= (($assignment->approved == '1') ? 'success' : (($assignment->approved == '0') ? 'default' : 'danger')) ?>">
                                ASS60-{{ $assignment->id }}
                            </span></h4>
                        </td>
                        <td style="text-align: center;">
                            {{ $assignment->depart_date }} {{ $assignment->depart_time }}
                        </td>
                        <td style="text-align: left;">

                            @foreach($assignment->assignreserve as $reserve)
                                <?php $reservation = App\Reservation::where(['id' => $reserve->reserve_id])->with('user')->first();
                                ?>

                                <?php
                                    // print_r($reservation->user);
                                    $locationIds = [];
                                    $locationList = '';
                                    $locationIds = explode(",", $reservation->location);
                                    $locations = App\Location::where('id','<>','1')
                                                    ->pluck('name','id')->toArray();

                                    $locationList = '<ul class="tag__list">';
                                    foreach ($locationIds as $key => $value) {
                                        if (!empty($value)) {                                    
                                            $locationList .= '                                        
                                                    <li>
                                                        <h5><span class="label label-info">' .$locations[$value]. '</span></h5>
                                                    </li>';
                                        }
                                    }
                                    $locationList .= '</ul>';
                                ?>
                                
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="label label-primary">
                                            {{ $reservation->id }}
                                        </span>
                                        <b>ไปราชการ</b> {{ $reservation->activity }}
                                        <span class="label label-{{ ($assignment->status=='1') ? 'success' : 'danger' }}">
                                            {{ ($assignment->status=='1') ? 'เที่ยวเดียว' : 'รอไปรับ/ส่ง' }}
                                        </span><br>

                                        <span class="label label-{{ ($reserve->times=='1') ? 'warning' : 'success' }}" ng-show="{{ $reservation->transport }} == 5">
                                            {{ ($reserve->times=='1') ? 'เที่ยวไป' : 'เที่ยวกลับ' }}
                                        </span><br>

                                        <b>ณ</b> <?= $locationList ?><br>
                                        <b>วันเวลาไป-กลับ</b> {{ $reservation->from_date }} {{ $reservation->from_time }} - {{ $reservation->to_date }} {{ $reservation->to_time }}<br>                      
                                        <b>จำนวนผู้โดยสาร</b> <a ng-click="showPassengers($event, {{ $reservation->id }})" class="btn btn-primary btn-xs">
                                            {{ $reservation->passengers }}
                                        </a> ราย ( <b>ผู้ขอ</b> {{ $reservation->user['person_firstname']. ' ' .$reservation->user['person_lastname']. ' / ' .$reservation->user['person_tel'] }} )
                                    </li>
                                </ul>

                            @endforeach
                        </td>
                        <td style="text-align: center;">
                            <?= (($vehicle) ? $vehicle->reg_no. ' ' .$vehicle->changwat->short : ''); ?>
                        </td>
                        <td style="text-align: center;">
                            <?= (($driver) ? $driver->description : ''); ?>
                            <div class="desc" ng-show="{{ ($assignment->start_time) ? true : false }}">
                                <p>เวลาออก {{ $assignment->start_time }}</p>
                                <p>เวลาถึง {{ $assignment->end_time }}</p>
                            </div>
                        </td>
                        <td style="text-align: center;">

                            <a  class="btn btn-success btn-xs"
                                ng-click="addReservationForm($event, {{ $assignment->id }}, '{{ $assignment->depart_date }}')"
                                title="เพิ่มรายการขอใช้รถ">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </a>

                            <a  class="btn btn-success btn-xs"
                                ng-click="showChangePopup($event, {{ $assignment->id }})"
                                title="เปลี่ยน พขร หรือ รถ"> 
                                <i class="fa fa-ambulance" aria-hidden="true"></i>
                            </a>
                            
                            <a  href="{{ url('/assign/edit/' .$assignment->id. '/' .$assignment->depart_date. '/' .$assignment->shift) }}" 
                                class="btn btn-warning btn-xs"
                                title="แก้ไขรายการ">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            @if ($assignment->status != '3' && Auth::user()->person_id == '1300200009261')
                                <a  href="{{ url('/assign/cancel/' . $assignment->id) }}" 
                                    ng-click="cancel($event)"
                                    class="btn btn-primary btn-xs"
                                    title="ยกเลิกรายการ">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                                <form id="cancel-form" action="{{ url('/assign/cancel/' . $assignment->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                </form>
                            @endif

                            @if (Auth::user()->person_id == '1300200009261')
                                @if ($assignment->status == '3')
                                    <a  href="{{ url('/assign/return/' . $assignment->id) }}" 
                                        ng-click="return($event)"
                                        class="btn btn-default btn-xs"
                                        title="กู้คืนรายการ">
                                        <i class="fa fa-retweet" aria-hidden="true"></i>
                                    </a>

                                    <form id="return-form" action="{{ url('/assign/return/' . $assignment->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                    </form>
                                @endif

                                <a  href="{{ url('/assign/delete/' . $assignment->id) }}" 
                                    ng-click="delete($event)"
                                    class="btn btn-danger btn-xs"
                                    title="ลบรายการ">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>

                                <form id="delete-form" action="{{ url('/assign/delete/' . $assignment->id) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
            <ul class="pagination">
                @if($assignments->currentPage() !== 1)
                    <li>
                        <a href="{{ $assignments->url($assignments->url(1)).'&fromdate='.$fromdate }}" aria-label="Previous">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif

                <li class="{{ ($assignments->currentPage() === 1) ? 'disabled' : '' }}">
                    <a href="{{ $assignments->url($assignments->currentPage() - 1).'&fromdate='.$fromdate }}" aria-label="Prev">
                        <span aria-hidden="true">Prev</span>
                    </a>
                </li>
                
                @for($i=$assignments->currentPage(); $i < $assignments->currentPage() + 10; $i++)
                    @if ($assignments->currentPage() <= $assignments->lastPage() && ($assignments->lastPage() - $assignments->currentPage()) > 10)
                        <li class="{{ ($assignments->currentPage() === $i) ? 'active' : '' }}">
                            <a href="{{ $assignments->url($i).'&fromdate='.$fromdate }}">
                                {{ $i }}
                            </a>
                        </li> 
                    @else
                        @if ($i <= $assignments->lastPage())
                            <li class="{{ ($assignments->currentPage() === $i) ? 'active' : '' }}">
                                <a href="{{ $assignments->url($i).'&fromdate='.$fromdate }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endif
                @endfor

                <li class="{{ ($assignments->currentPage() === $assignments->lastPage()) ? 'disabled' : '' }}">
                    <a href="{{ $assignments->url($assignments->currentPage() + 1).'&fromdate='.$fromdate }}" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </a>
                </li>

                @if($assignments->currentPage() !== $assignments->lastPage())
                    <li>
                        <a href="{{ $assignments->url($assignments->lastPage()).'&fromdate='.$fromdate }}" aria-label="Previous">
                            <span aria-hidden="true">Last</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
        <!-- right column -->
    </div><!-- /.row -->
    
    <!-- Modal Show Passengers -->
    <div class="modal fade" id="dlgPassengers" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">รายชื่อผู้ร่วมเดินทาง</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 4%; text-align: center;">#</th>
                                    <th style="width: 8%; text-align: center;">CID</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th style="width: 30%; text-align: center;">ตำแหน่ง</th>
                                    <!-- <th style="width: 30%; text-align: center;">สังกัด</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index, passenger) in passengers">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ passenger.id }}</td>
                                    <td>@{{ passenger.name  }}</td>
                                    <td>@{{ passenger.position  }}</td>
                                    <!-- <td></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Show Passengers -->

    <!-- Modal Change -->
    <div class="modal fade" id="dlgChange" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">บันทึกเปลี่ยน พขร./รถ</h4>
                </div>
                <div class="modal-body">
                    <form id="change-form" action="{{ url('/assign/ajaxchange') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="assignid" name="assignid">
                        
                        <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('driver')}">
                            <label class="control-label" for="driver">พนักงานขับรถ</label>
                            <select id="driver" 
                                    name="driver"
                                    class="form-control">
                                <option value="">-- กรุณาเลือกพนักงานขับรถ --</option>

                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->driver_id }}">
                                        {{ $driver->description }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('driver')"></span> -->
                            <span class="help-block" ng-show="checkValidate('driver')">กรุณาเลือกพนักงานขับรถ</span>
                        </div> 

                        <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('vehicle')}">
                            <label class="control-label" for="vehicle">รถ</label>
                            <select id="vehicle" 
                                    name="vehicle"
                                    class="form-control">
                                <option value="">-- กรุณาเลือกรถ --</option>

                                @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->vehicle_id }}">
                                    {{ $vehicle->vehicle_id. '-' .$vehicle->vehicle_cate_name. ' ' .$vehicle->manufacturer_name. ' ' .$vehicle->model. ' ทะเบียน ' .$vehicle->reg_no }} {{ ($vehicle->remark) ? $vehicle->remark : '' }}
                                </option>
                                @endforeach
                                
                            </select>
                            <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('vehicle')"></span> -->
                            <span class="help-block" ng-show="checkValidate('vehicle')">กรุณาเลือกรถ</span>
                        </div>
                    </form>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="changeVehicle($event)">
                        Save
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Change -->

    <!-- Modal Add Reservation -->
    <div class="modal fade" id="dlgReservation" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">เพิ่มรายการขอใช้รถ</h4>
                </div>
                <div class="modal-body">
                    <form id="add-reserve-form" action="{{ url('/assign/ajaxadd_reservation') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="aid" name="aid">
                        <input type="hidden" id="rid" name="rid">
                        <input type="hidden" id="times" name="times">
                        <input type="hidden" id="allday" name="allday">
                        <input type="hidden" id="status" name="status">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="assign_date">วันที่ขอใช้รถ</label>
                                    <input  type="text" 
                                            id="reserve_date" 
                                            name="reserve_date"
                                            class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <b>ช่วงเวลา :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input  type="radio" id="shifts" name="shifts" 
                                        ng-click="loadVehicleIsIdle()" 
                                        ng-model="shifts"
                                        ng-value="1"> 00.01 - 12.00 น. &nbsp;&nbsp;&nbsp;&nbsp;
                                <input  type="radio" id="shifts" name="shifts" 
                                        ng-click="loadVehicleIsIdle()" 
                                        ng-model="shifts"
                                        value="2"> 12.00 - 23.59 น.
                            </div>
                        </div><br>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 3%; text-align: center;">#</th>
                                        <th>กิจกรรม</th>
                                        <th style="width: 25%; text-align: center;">สถานที่</th>
                                        <th style="width: 15%; text-align: center;">ผู้ขอ/เบอร์ติดต่อ</th>
                                        <th style="width: 15%; text-align: center;">ช่วงเวลา</th>
                                        <th style="width: 8%; text-align: center;">จำนวนผู้โดยสาร</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(index, r) in reservations">
                                        <td style="text-align: center;">
                                            <div class="form-group">
                                                <input  type="checkbox" 
                                                        id="reservations[]" 
                                                        name="reservations[]" 
                                                        value="@{{ r.id }}"
                                                        ng-click="createAssignOptions(r, '1'); addReserveId(r)">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="label label-primary">
                                                @{{ r.id }}
                                            </span>

                                            <span class="text-muted small">
                                                (@{{ r.reserve_date }})
                                            </span>

                                            @{{ r.activity }} 
                                            <span class="label label-danger">
                                                @{{ transport[r.transport] }}
                                            </span>

                                            <div class="form-group" ng-show="(r.transport == 5 && r.status != 4) || (r.transport == 3 && r.num_day > 1)">
                                                <input  type="checkbox" 
                                                        id="reservations[]" 
                                                        name="reservations[]" 
                                                        value="@{{ r.id }}"
                                                        ng-click="createAssignOptions(r, 1); addReserveId(r)"
                                                        ng-disabled="r.status == 3"> เที่ยวไป/มา

                                                <input  type="checkbox" 
                                                        id="reservations[]" 
                                                        name="reservations[]" 
                                                        value="@{{ r.id }}"
                                                        ng-click="createAssignOptions(r, 2); addReserveId(r)"
                                                        ng-disabled="r.status == 0 || r.status == 1"> เที่ยวกลับ
                                            </div>
                                        </td>
                                        <td>
                                            <ul style="margin: 10px; padding: 0px; font-size: 12px;">
                                                <li ng-repeat="(index, location) in createLocationView(r.locations)">
                                                    @{{ location }}
                                                </li>
                                            </ul>
                                        </td>
                                        <td>@{{ r.user }}</td>
                                        <td style="text-align: center;">
                                            @{{ r.from_time + '-' + r.to_time + ' น.' }}
                                        </td>
                                        <td style="text-align: center;">
                                            @{{ r.passengers + ' ราย' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="addReservation($event)">
                        Save
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Reservation -->

</div><!-- /.container -->

<script>
    $(document).ready(function($) {
        var dateNow = new Date();

        $('#fromdate').datetimepicker({
            useCurrent: true,
            format: 'YYYY-MM-DD',
            defaultDate: moment(dateNow)
        })

        $('#reserve_date').datetimepicker({
            useCurrent: true,
            format: 'YYYY-MM-DD',
            defaultDate: moment(dateNow),
        })
    });
 </script>

@endsection
