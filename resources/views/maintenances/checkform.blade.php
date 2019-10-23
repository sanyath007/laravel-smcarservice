    @extends('layouts.main')

    @section('content')
    <div class="container-fluid" ng-controller="maintainedCtrl" ng-init="popUpAllVehicle()">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บันทึกการตรวจสภาพรถและอุปกรณ์ประจำรถ</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-car" aria-hidden="true"></i> 
                บันทึกการตรวจสภาพรถและอุปกรณ์ประจำรถ <br>
                @{{ frmVehicleDetail }}
                
                <a class="btn btn-warning" ng-show="frmVehicleDetail" ng-click="popUpAllVehicle()">
                    <i class="fa fa-car" aria-hidden="true"></i>
                    เปลี่ยนรถ
                </a>
            </span>
        </div>

        <hr />
        <!-- page title -->
        
        <form action="{{ url('/maintained/adddailycheck') }}" method="post">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">วันที่เช็ค</label>
                        <input type="text" id="check_date" name="check_date" class="form-control" readonly="readonly">
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">เลขระยะทาง (เลขไมล์)</label>
                        <input type="text" id="current_mileage" name="current_mileage" class="form-control" placeholder="ระบุเลขระยะทาง&hellip;">
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">1. ล้อ และลมยาง ทั้ง 5 ล้อ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="tires" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="tires" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="tires" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="tires" id="tires" value="0">
                        </div>

                        <input type="text" name="tires_text" id="tires_text" class="form-control" placeholder="ระบุความผิดปกติของยางและลมยาง&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">2. รอยรั่วน้ำมันใต้ท้องรถ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="leak" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="leak" data-title="1">ไม่มี</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="leak" data-title="2">&nbsp;มี&nbsp;</a>
                            </div>
                            <input type="hidden" name="leak" id="leak" value="0">
                        </div>

                        <input type="text" name="leak_text" id="leak_text" class="form-control" placeholder="ระบุรอยรั่ว&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">3. หม้อน้ำ และระดับน้ำ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="radiator" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="radiator" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="radiator" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="radiator" id="radiator" value="0">
                        </div>

                        <input type="text" name="radiator_text" id="radiator_text" class="form-control" placeholder="ระบุความผิดปกติของระดับน้ำและหม้อน้ำ&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">4. น้ำมันหล่อลื่น</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="oil" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="oil" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="oil" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="oil" id="oil" value="0">
                        </div>
                        
                        <input type="text" name="oil_text" id="oil_text" class="form-control" placeholder="ระบุความผิดปกติของระดับน้ำมันหล่อลื่น&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">5. เบรก/ครัช และน้ำมันเบรก/ครัช</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="brake_clutch" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="brake_clutch" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="brake_clutch" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="brake_clutch" id="brake_clutch" value="0">
                        </div>

                        <input type="text" name="brake_clutch_text" id="brake_clutch_text" class="form-control" placeholder="ระบุความผิดปกติของเบรก/ครัชและน้ำมันเบรก/ครัช&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">6. แบตเตอรี่ และน้ำกลั่น</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="battery" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="battery" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="battery" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="battery" id="battery" value="0">
                        </div>

                        <input type="text" name="battery_text" id="battery_text" class="form-control" placeholder="ระบุความผิดปกติของแบตเตอรี่และน้ำกลั่น&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">7. ใบปัดน้ำฝน และน้ำยาฉีดกระจก</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="windshield" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="windshield" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="windshield" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="windshield" id="windshield" value="0">
                        </div>

                        <input type="text" name="windshield_text" id="windshield_text" class="form-control" placeholder="ระบุความผิดปกติน้ำฉีดกระจก&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">8. ปริมาณน้ำมันเชื้อเพลิง</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="fuel" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="fuel" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="fuel" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="fuel" id="fuel" value="0">
                        </div>

                        <input type="text" name="fuel_text" id="fuel_text" class="form-control" placeholder="ระบุปริมาณน้ำมันเชื้อเพลิง&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">9. การทำงานมาตรวัดต่างๆ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="gauges" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="gauges" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="gauges" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="gauges" id="gauges" value="0">
                        </div>

                        <input type="text" name="gauges_text" id="gauges_text" class="form-control" placeholder="ระบุความผิดปกติสัญญาณไซเรน&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">10. ไฟสัญญาณและไฟส่องสว่าง</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="lights" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="lights" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="lights" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="lights" id="lights" value="0">
                        </div>

                        <input type="text" name="lights_text" id="lights_text" class="form-control" placeholder="ระบุความผิดปกติไฟสัญญาณและไฟส่องสว่าง&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row" ng-show="frmVehicle.vehicle_type!=1">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">11. ออกซิเจน</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="oxygen" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="oxygen" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="oxygen" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="oxygen" id="oxygen" value="0">
                        </div>

                        <input type="text" name="oxygen_text" id="oxygen_text" class="form-control" placeholder="ระบุความผิดปกติออกซิเจน&hellip;">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">12. ระบบสัญญาณไซเรน</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="siren" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="siren" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="siren" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="siren" id="siren" value="0">
                        </div>
                        
                        <input type="text" name="siren_text" id="siren_text" class="form-control" placeholder="ระบุความผิดปกติสัญญาณไซเรน&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6" ng-show="frmVehicle.vehicle_type!=1">
                    <div class="form-group">
                        <label for="ID">13. ระบบวิทยุสื่อสาร</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="radio" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="radio" data-title="1">ปกติ</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="radio" data-title="2">ไม่ปกติ</a>
                            </div>
                            <input type="hidden" name="radio" id="radio" value="0">
                        </div>

                        <input type="text" name="radio_text" id="radio_text" class="form-control" placeholder="ระบุความผิดปกติวิทยุสื่อสาร&hellip;">
                    </div>

                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">14. ร่องรอยเสียหายบริเวณตัวรถ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="damage" data-title="0">ไม่ได้เช็ค</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="damage" data-title="1">ไม่มี</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="damage" data-title="2">&nbsp;มี&nbsp;</a>
                            </div>
                            <input type="hidden" name="damage" id="damage" value="0">
                        </div>

                        <input type="text" name="damage_text" id="damage_text" class="form-control" placeholder="ระบุร่องรอยเสียหาย&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->           

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="ID">15. ล้างรถ</label>
                        <div class="input-group">
                            <div id="radioBtn" class="btn-group">
                                <a class="btn btn-primary btn-sm active" data-toggle="is_washed" data-title="0">ไม่ได้ล้าง</a>
                                <a class="btn btn-primary btn-sm notActive" data-toggle="is_washed" data-title="1">ล้าง</a>
                            </div>
                            <input type="hidden" name="is_washed" id="is_washed" value="0">
                        </div>
                    </div>

                    <label>ภาพรถหลังการล้าง</label>
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('uploads/default-img.gif') }}" width="100%" height="100%" alt="" style="border: 1px solid #000;">

                                    <div class="form-group">
                                        <label for="">ด้านหน้า</label>
                                        <input type="file" id="car_washed_front" name="car_washed_front" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('uploads/default-img.gif') }}" width="100%" height="100%" alt="" style="border: 1px solid #000;">

                                    <div class="form-group">
                                        <label for="">ด้านหลัง</label>
                                        <input type="file" id="car_washed_back" name="car_washed_back"  class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ asset('uploads/default-img.gif') }}" width="100%" height="100%" alt="" style="border: 1px solid #000;">

                                    <div class="form-group">
                                        <label for="">ด้านซ้าย</label>
                                        <input type="file" id="car_washed_left" name="car_washed_left"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset('uploads/default-img.gif') }}" width="100%" height="100%" alt="" style="border: 1px solid #000;">

                                    <div class="form-group">
                                        <label for="">ด้านขวา</label>
                                        <input type="file" id="car_washed_right" name="car_washed_right"  class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- left column -->
            </div>
            
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="ID">หมายเหตุ</label>
                        <textarea id="remark" name="remark" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <br><button class="btn btn-primary pull-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>
                </div>
            </div>

            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->person_id }}">
            <input type="hidden" id="vehicle_id" name="vehicle_id" value="{{ $vehicle->vehicle_id }}">
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

                $('#check_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                });

                $('#radioBtn a').on('click', function(){
                    var sel = $(this).data('title');
                    var tog = $(this).data('toggle');
                    $('#'+tog).prop('value', sel);
                    
                    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
                });
            });
        </script>

    </div><!-- /.container -->
    @endsection
