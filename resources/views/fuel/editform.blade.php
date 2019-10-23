    @extends('layouts.main')

    @section('content')
    <div class="container-fluid" ng-controller="fuelCtrl" ng-init="loadEditData()">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/fuel/list') }}">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขข้อมูลการใช้น้ำมันเชื้อเพลิง</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
                แก้ไขข้อมูลการใช้น้ำมันเชื้อเพลิง ID : 
                <span class="label label-warning" style="padding: 5px;">
                    &nbsp;&nbsp;{{ $fuel->id }}&nbsp;&nbsp;
                </span>                
            </span>
        </div>

        <hr />
        <!-- page title -->
        
        <form id="frmEditFuel" action="{{ url('/fuel/update') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('department')}">
                        <label for="bill_date">
                            หน่วยงานที่เบิก <span style="color: red;">*</span>
                        </label><br>
                        <input  type="radio" 
                                id="department" 
                                name="department"
                                value="1"
                                {{ ($fuel->department=='1') ? 'checked' : '' }}
                                ng-model="newFuel.department"> โรงพยาบาลเทพรัตน์นครราชสีมา
                        <input  type="radio" 
                                id="department" 
                                name="department"
                                value="2"
                                {{ ($fuel->department=='2') ? 'checked' : '' }}
                                ng-model="newFuel.department"> ศูนย์แพทย์ชุมชนเมือง 3 วัดบูรพ์
                        <input  type="radio" 
                                id="department" 
                                name="department"
                                value="3"
                                {{ ($fuel->department=='3') ? 'checked' : '' }}
                                ng-model="newFuel.department"> ศูนย์แพทย์ชุมชนเมือง 9 ราชภัฏ
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('department')"></span>
                        <span class="help-block" ng-show="checkValidate('department')">กรุณาเลือกวันที่บิลน้ำมัน</span>
                    </div>
                </div>
                <!-- left column -->
            </div><!-- end row -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('billDate')}">
                        <label for="bill_date">
                            วันที่บิลน้ำมัน <span style="color: red;">*</span>
                        </label>
                        <input  type="text" 
                                id="bill_date" 
                                name="bill_date"
                                value="{{ $fuel->bill_date }}"
                                ng-model="newFuel.billDate"
                                class="form-control">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('billDate')"></span>
                        <span class="help-block" ng-show="checkValidate('billDate')">กรุณาเลือกวันที่บิลน้ำมัน</span>
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('billNo')}">
                        <label for="bill_no">เลขที่บิลน้ำมัน <span style="color: red;">*</span></label>
                        <input  type="text" 
                                id="bill_no" 
                                name="bill_no"
                                value="{{ $fuel->bill_no }}"
                                ng-model="newFuel.billNo" 
                                class="form-control">
                        <span   class="glyphicon glyphicon-remove form-control-feedback" 
                                ng-show="checkValidate('billNo')"></span>
                        <span class="help-block" ng-show="checkValidate('billNo')">กรุณาระบุเลขที่บิลน้ำมัน</span>
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('vehicle')}">
                        <label class="control-label" for="company">
                            รถ <span style="color: red;">*</span> {{ $fuel->vehicle_id }}
                        </label>
                        <select id="vehicle" 
                                name="vehicle" 
                                ng-model="newFuel.vehicle"
                                ng-change="setJobDescWithVehicle()" 
                                class="form-control">
                            <option value="">-- กรุณาเลือกรถ --</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->vehicle_id }}"
                                        {{ ($fuel->vehicle_id==$vehicle->vehicle_id) ? 'selected' : '' }}>
                                    {{ $vehicle->cate->vehicle_cate_name.' ('.$vehicle->reg_no.')' }}
                                </option>
                            @endforeach
                        </select>

                        <span class="help-block" ng-show="checkValidate('company')">กรุณาเลือกบริษัท</span>                        
                    </div>
                </div>
                <!-- left column -->

                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('fuelType')}">
                        <label class="control-label" for="fuel_type">
                            ประเภทน้ำมัน <span style="color: red;">*</span>
                        </label>
                        <select id="fuel_type" 
                                name="fuel_type" 
                                ng-model="newFuel.fuelType" 
                                class="form-control">
                            <option value="">-- กรุณาเลือกประเภทน้ำมัน --</option>
                            @foreach ($fuel_types as $type)
                                <option value="{{ $type->fuel_type_id }}"
                                        {{ ($fuel->fuel_type_id==$type->fuel_type_id) ? 'selected' : '' }}>
                                    {{ $type->fuel_type_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- <span  class="glyphicon glyphicon-remove form-control-feedback" 
                                    ng-show="checkValidate('insuranceType')"></span> -->
                        <span class="help-block" ng-show="checkValidate('fuelType')">กรุณาเลือกประเภทประกันภัย</span>                        
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-4">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('volume')}">
                        <label class="control-label" for="from_date">
                            จำนวนลิตร <span style="color: red;">*</span>
                        </label>
                        <input  type="text" 
                                id="volume" 
                                name="volume" 
                                value="{{ $fuel->volume }}"
                                class="form-control" 
                                ng-model="newFuel.volume">
                        <span   class="glyphicon glyphicon-remove form-control-feedback" 
                                ng-show="checkValidate('volume')"></span>
                        <span class="help-block" ng-show="checkValidate('volume')">กรุณาระบุจำนวนลิตร</span>
                    </div>
                </div>
                <!-- left column -->
                
                <!-- right column -->
                <div class="col-md-4">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('unitPrice')}">
                        <label class="control-label" for="to_date">
                            ราคา/ลิตร <span style="color: red;">*</span>
                        </label>
                        <input  type="text" 
                                id="unit_price" 
                                name="unit_price" 
                                value="{{ $fuel->unit_price }}"
                                class="form-control" 
                                ng-model="newFuel.unitPrice"
                                ng-blur="calculateTotal()">
                        <span   class="glyphicon glyphicon-remove form-control-feedback" 
                                ng-show="checkValidate('unitPrice')"></span>
                        <span class="help-block" ng-show="checkValidate('unitPrice')">กรุณาระบุราคา/ลิตร</span>
                    </div>
                </div><!-- right column -->

                <!-- right column -->
                <div class="col-md-4">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('total')}">
                        <label class="control-label" for="to_date">
                            รวมราคา <span style="color: red;">*</span>
                        </label>
                        <input  type="text" 
                                id="total" 
                                name="total" 
                                value="{{ $fuel->total }}"
                                class="form-control" 
                                ng-model="newFuel.total">
                        <span   class="glyphicon glyphicon-remove form-control-feedback" 
                                ng-show="checkValidate('total')"></span>
                        <span class="help-block" ng-show="checkValidate('total')">กรุณาระบุรวมราคา</span>
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('jobDesc')}">
                        <label class="control-label" for="job_desc">
                            งานที่ปฏิบัติ <span style="color: red;">*</span>
                        </label>
                        <textarea   id="job_desc" 
                                    name="job_desc" 
                                    ng-model="newFuel.jobDesc" 
                                    cols="30" 
                                    rows="5" 
                                    class="form-control">{{ $fuel->job_desc }}</textarea>
                        <span   class="glyphicon glyphicon-remove form-control-feedback" 
                                ng-show="checkValidate('jobDesc')"></span>
                        <span class="help-block" ng-show="checkValidate('jobDesc')">กรุณาระบุรายละเอียดงานที่ปฏิบัติ</span>
                    </div>
                </div>
                <!-- left column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                   <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('remark')}">
                        <label class="control-label" for="remark">หมายเหตุ</label>
                        <textarea   id="remark" 
                                    name="remark" 
                                    cols="30" 
                                    rows="5" 
                                    class="form-control">{{ $fuel->remark }}</textarea>
                    </div>
                </div>
                <!-- left column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <div class="form-group">
                        <label class="control-label" for="attachfile">แนบไฟล์</label>
                        <input type="file" id="attachfile" name="attachfile" class="form-control" placeholder="สถานที่&hellip;" ng-keyup="queryLocation($event)" autocomplete="off" ng-keypress="enterToAddLocation($event)">
                    </div>

                </div>
                <!-- left column -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <br><button class="btn btn-warning pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-pencil" aria-hidden="true"></i> แก้ไข
                    </button>
                </div>
            </div>

            <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
            <input type="hidden" id="id" name="id" value="{{ $fuel->id }}">
            {{ csrf_field() }}
        </form>

        <!-- Modal -->
        <div class="modal fade" id="dlgAllVehicle" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                        <h4 class="modal-title" id="">กรุณาเลือกรถ</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 4%; text-align: center;">#</th>
                                        <th style="width: 15%; text-align: center;">ทะเบียน</th>
                                        <th>รายละเอียดรถ</th>
                                        <th style="width: 30%; text-align: center;">ผู้รับผิดชอบ</th>
                                        <th style="width: 5%; text-align: center;">เลือก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(index, vehicle) in frmAllVehicles.data">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ vehicle.reg_no }} @{{ vehicle.changwat.short }}</td>
                                        <td>
                                            @{{ vehicle.cate.vehicle_cate_name }}
                                            @{{ vehicle.manufacturer.manufacturer_name }}
                                            @{{ vehicle.model }}
                                            @{{ (vehicle.remark) ? '(' + vehicle.remark + ')' : '' }}
                                        </td>
                                        <td>@{{   }}</td>
                                        <td>
                                            <a class="btn btn-primary" ng-click="frmSetVehicle(vehicle)">
                                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 

                        <ul class="pagination">
                            <li>
                                <a ng-click="paginate($event, frmAllVehicles.path)" aria-label="First">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>

                            <li ng-class="{ 'disabled': (frmAllVehicles.current_page === 1) }">
                                <a  ng-click="paginate($event, frmAllVehicles.prev_page_url)" 
                                    aria-label="Prev">
                                    <span aria-hidden="true">Prev</span>
                                </a>
                            </li>                         
                           
                            <li ng-repeat="i in _.range(1, frmAllVehicles.last_page + 1)"
                                ng-class="{ 'active': (frmAllVehicles.current_page === i) }">
                                <a ng-click="paginate($event, frmAllVehicles.path + '?page=' + i)">
                                    {{ i }}
                                </a>
                            </li>
                            
                            <li ng-class="{ 'disabled': (frmAllVehicles.current_page === frmAllVehicles.last_page) }">
                                <a ng-click="paginate($event, frmAllVehicles.next_page_url)" aria-label="Next">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>

                            <li>
                                <a ng-click="paginate($event, frmAllVehicles.path + '?page=' + frmAllVehicles.last_page)" aria-label="Last">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul> 

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Modal -->
        
        <script>
            $(document).ready(function($) {
                var dateNow = new Date();

                $('#bill_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                }); 

                // $("#activity").tagsinput('items')
            });
        </script>

    </div><!-- /.container -->
    @endsection
