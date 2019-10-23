@extends('layouts.main')

@section('content')
    <div class="container-fluid" ng-controller="assignCtrl">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บันทึกการจัดรถ</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> บันทึกการจัดรถ
            </span>
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

                <form id="frmNewReserve" action="{{ url('/assign/add') }}" method="post" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="assign_date">วันที่ใช้รถ</label>
                                <input type="text" id="reserve_date" name="reserve_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <b>ช่วงเวลา :</b>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input  type="radio" id="shifts" name="shifts" 
                                    ng-click="loadVehicleIsIdle()" 
                                    ng-model="shifts"
                                    ng-value="1"> 00.01 - 12.00 น. &nbsp;&nbsp;&nbsp;&nbsp;
                            <input  type="radio" id="shifts" name="shifts" 
                                    ng-click="loadVehicleIsIdle()" 
                                    ng-model="shifts"
                                    value="2"> 12.00 - 23.59 น.
                                                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input  type="radio" id="" name="shifts" 
                                    ng-click="loadVehicleIsIdle()" 
                                    ng-model="shifts"
                                    value="3"> นอกเวลาราชการ (16.01 - 24.00)
                                                        <input  type="radio" id="" name="shifts" 
                                    ng-click="loadVehicleIsIdle()" 
                                    ng-model="shifts"
                                    value="4"> นอกเวลาราชการ (00.01 - 08.00 น.) -->
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
                                                    ng-click="createAssignOptions(r, '1')">
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
                                                    ng-click="createAssignOptions(r, 1)"
                                                    ng-disabled="r.status == 3"> เที่ยวไป/มา

                                            <input  type="checkbox" 
                                                    id="reservations[]" 
                                                    name="reservations[]" 
                                                    value="@{{ r.id }}"
                                                    ng-click="createAssignOptions(r, 2)"
                                                    ng-disabled="r.status == 0 || r.status == 1"> เที่ยวกลับ
                                        </div>
                                    </td>
                                    <td>
                                        <ul>
                                            <li ng-repeat="(index, location) in createLocationView(r.locations)">
                                                <h5>
                                                    <span class="label label-info">
                                                        @{{ location }}
                                                    </span>
                                                </h5>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('driver')}">
                                <label class="control-label" for="driver">พนักงานขับรถ</label>
                                <select id="driver" 
                                        name="driver"
                                        class="form-control">
                                    <option value="">-- กรุณาเลือกพนักงานขับรถ --</option>
                                    <option value="@{{ d.driver_id }}" ng-repeat="d in drivers">
                                        @{{ d.description }}
                                    </option>
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
                                    <option value="@{{ v.vehicle_id }}" ng-repeat="v in vehicles">
                                        @{{ v.vehicle_id + '-' + v.vehicle_cate_name + ' ' + v.manufacturer_name + ' ' + v.model + ' ทะเบียน ' + v.reg_no }} @{{ (v.remark) ? v.remark : '' }}
                                    </option>
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
                                <input type="text" id="depart_date" name="depart_date" class="form-control">
                            </div>
                        </div>
                        <!-- left column -->
                    
                        <!-- right column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="assign_time">เวลา</label>
                                <input type="text" id="depart_time" name="depart_time" class="form-control">
                            </div>
                        </div><!-- right column -->
                    </div><!-- end row -->

                    <button class="btn btn-primary pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>

                    {{ csrf_field() }}
                    <input type="hidden" id="times" name="times">
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