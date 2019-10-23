@extends('layouts.main')

@section('content')
    <div class="container-fluid" ng-controller="assignCtrl">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข้อมูลการจัดรถ</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                แก้ไขข้อมูลการจัดรถ
                ({{ $assignment[0]->id }})
            </span>
        </div>

        <hr />
        <!-- page title -->
        <div class="row">
            <div class="col-md-12">

                <form id="frmEditAssign" action="{{ url('/assign/update') }}" method="post" enctype="multipart/form-data">

                    <div class="table-responsive"">
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
                                <?php $transport = [
                                            '1' => "ส่งเที่ยวเดียว",
                                            '2' => "รับเที่ยวเดียว",
                                            '3' => "ไป-กลับ (รอรับกลับวันเดียว)",
                                            '4' => "ไป-กลับ (รอรับกลับค้างคืน)",
                                            '5' => "ไป-กลับ (ส่งไว้และไปรับเวลากลับ)",
                                            '9' => "ขับเอง (เฉพาะกรณีผู้ขอเป็นพนักงานขับรถสำรอง)"
                                ]; ?>

                                @foreach ($assignment[0]->assignreserve as $r)
                                    <?php 
                                        $reserve = App\Reservation::where(['id' => $r->reserve_id])
                                                    ->with('user')
                                                    ->first();
                                    ?>

                                    <tr>
                                        <td style="text-align: center;">
                                            <div class="form-group">
                                                <span class="label label-primary" ng-show="{{ (($reserve->transport == 5 && $reserve->status != 4) || ($reserve->transport == 3 && $reserve->num_day > 1)) ? true : false }}">
                                                    {{ $reserve->id }}
                                                </span>

                                                <input  type="checkbox" 
                                                        id="" 
                                                        name="reservations[]" 
                                                        value="{{ $reserve->id }}"
                                                        checked="checked"
                                                        ng-show="{{ (($reserve->transport == 5 && $reserve->status != 4) || ($reserve->transport == 3 && $reserve->num_day > 1)) ? false : true }}">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="label label-primary" ng-show="{{ (($reserve->transport == 5 && $reserve->status != 4) || ($reserve->transport == 3 && $reserve->num_day > 1)) ? false : true }}">
                                                {{ $reserve->id }}
                                            </span>

                                            {{ $reserve->activity }} 
                                            <span class="label label-danger">
                                                {{ ($reserve->transport) ? $transport[$reserve->transport] : '' }}
                                            </span>

                                            <div class="form-group" ng-show="{{ (($reserve->transport == 5 && $reserve->status != 4) || ($reserve->transport == 3 && $reserve->num_day > 1)) ? true : false }}">
                                                <input  type="checkbox" 
                                                        id="times[]" 
                                                        name="times[]" 
                                                        value="1"
                                                        ng-checked="{{ ($r->times == 1) ? true : false }}"> เที่ยวไป/มา

                                                <input  type="checkbox" 
                                                        id="times[]" 
                                                        name="times[]" 
                                                        value="2"
                                                        ng-checked="{{ ($r->times == 2) ? true : false }}"> เที่ยวกลับ
                                            </div>
                                        </td>
                                        <td>
                                            <ul>
                                                <?php $arrLocation = explode(',', $reserve->location); ?>
                                                @foreach ($arrLocation as $l)
                                                    <?php 
                                                        $location = App\Location::where(['id' => $l])
                                                                    ->first();
                                                    ?>

                                                    <li>
                                                        <h5>
                                                            <span class="label label-info">
                                                                {{ $location->name }}
                                                            </span><br>
                                                            <span class="label label-info">
                                                                {{ $location->address }}
                                                            </span>                   
                                                        </h5>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $reserve->user->person_firstname. '  ' .$reserve->user->person_lastname }} / {{ $reserve->user->person_tel }}</td>
                                        <td style="text-align: center;">
                                            {{ $reserve->from_time. '-' .$reserve->to_time. ' น.' }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $reserve->passengers. ' ราย' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('driver')}">
                                <label class="control-label" for="driver">พนักงานขับรถ</label>
                                <select id="driver" 
                                        name="driver"
                                        class="form-control">
                                    <option value="">-- กรุณาเลือกพนักงานขับรถ --</option>

                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->driver_id }}" {{ ($driver->driver_id == $assignment[0]->driver_id) ? 'selected' : '' }}>
                                            {{ $driver->description }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('driver')"></span> -->
                                <span class="help-block" ng-show="checkValidate('driver')">กรุณาเลือกพนักงานขับรถ</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('vehicle')}">
                                <label class="control-label" for="vehicle">รถ</label>
                                <select id="vehicle" 
                                        name="vehicle"
                                        class="form-control">
                                    <option value="">-- กรุณาเลือกรถ --</option>

                                    @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->vehicle_id }}" {{ ($vehicle->vehicle_id == $assignment[0]->vehicle_id) ? 'selected' : '' }}>
                                        {{ $vehicle->vehicle_id. '-' .$vehicle->vehicle_cate_name. ' ' .$vehicle->manufacturer_name. ' ' .$vehicle->model. ' ทะเบียน ' .$vehicle->reg_no }} {{ ($vehicle->remark) ? $vehicle->remark : '' }}
                                    </option>
                                    @endforeach
                                    
                                </select>
                                <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('vehicle')"></span> -->
                                <span class="help-block" ng-show="checkValidate('vehicle')">กรุณาเลือกรถ</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="depart_date">วันที่เดินทาง</label>
                                <input type="text" id="depart_date" name="depart_date" class="form-control" value="{{ $assignment[0]->depart_date }}">
                            </div>
                        </div>
                        <!-- left column -->
                    
                        <!-- right column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="assign_time">เวลา</label>
                                <input type="text" id="depart_time" name="depart_time" class="form-control" value="{{ $assignment[0]->depart_time }}">
                            </div>
                        </div><!-- right column -->
                    </div><!-- end row -->

                    <button class="btn btn-primary pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>

                    {{ csrf_field() }}                    
                    <input type="hidden" id="assid" name="assid" value="{{ $assignment[0]->id }}">
                    <input type="hidden" id="allday" name="allday">
                    <input type="hidden" id="status" name="status">

                </form>

            </div>
        </div>

        <script>
            $(document).ready(function($) {
                var dateNow = new Date();

                $('#reserve_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                })
                .on("dp.change", function(e) {
                    $('#depart_date').data('DateTimePicker').date(e.date);
                });

                $('#depart_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                });

                $('#depart_time').datetimepicker({
                    useCurrent: true,
                    format: 'HH:mm',
                    defaultDate: moment(dateNow).hours(8).minutes(0).seconds(0).milliseconds(0) 
                }); 
            });
        </script>
    </div><!-- /.container -->
@endsection