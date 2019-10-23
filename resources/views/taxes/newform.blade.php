    @extends('layouts.main')

    @section('content')
    <div class="container-fluid" ng-controller="taxCtrl" ng-init="popUpAllVehicle()">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บันทึกการเสียภาษี</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 
                บันทึกการเสียภาษี
                @{{ frmVehicleDetail }}

                <a class="btn btn-warning" ng-show="frmVehicleDetail" ng-click="popUpAllVehicle()">
                    <i class="fa fa-car" aria-hidden="true"></i>
                    เปลี่ยนรถ
                </a>
            </span>
        </div>

        <hr />
        <!-- page title -->
        
        <form id="frmNewTax" action="{{ url('/tax/add') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('docNo')}">
                        <label for="doc_no">เลขที่หนังสือขออนุมัติ <span style="color: red;">*</span></label>
                        <input type="text" id="doc_no" name="doc_no" ng-model="newTax.docNo" class="form-control">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('docNo')"></span>
                        <span class="help-block" ng-show="checkValidate('docNo')">กรุณาระบุเลขที่หนังสือขออนุมัติ</span>
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('docDate')}">
                        <label for="doc_date">วันที่หนังสือขออนุมัติ <span style="color: red;">*</span></label>
                        <input type="text" id="doc_date" name="doc_date" ng-model="newTax.docDate" class="form-control">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('docDate')"></span>
                        <span class="help-block" ng-show="checkValidate('docDate')">กรุณาเลือกวันที่หนังสือขออนุมัติ</span>
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('taxStartDate')}">
                        <label class="control-label" for="tax_start_date">วันที่เสียภาษี <span style="color: red;">*</span></label>
                        <input type="text" id="tax_start_date" name="tax_start_date" class="form-control" ng-model="newTax.taxStartDate">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('taxStartDate')"></span>
                        <span class="help-block" ng-show="checkValidate('taxStartDate')">กรุณาเลือกวันที่</span>
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('taxRenewalDate')}">
                        <label class="control-label" for="tax_renewal_date">วันที่ครบกำหนด <span style="color: red;">*</span></label>
                        <input type="text" id="tax_renewal_date" name="tax_renewal_date" class="form-control" ng-model="newtax.taxRenewalDate">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('taxRenewalDate')"></span>
                        <span class="help-block" ng-show="checkValidate('taxRenewalDate')">กรุณาเลือกวันที่</span>
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('taxReceiptNo')}">
                        <label for="tax_receipt_no">เลขที่ใบเสร็จ <span style="color: red;">*</span></label>
                        <input type="text" id="tax_receipt_no" name="tax_receipt_no" ng-model="newTax.taxReceiptNo" class="form-control">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('docNo')"></span>
                        <span class="help-block" ng-show="checkValidate('taxReceiptNo')">กรุณาระบุเลขที่ใบเสร็จ</span>
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('taxCharge')}">
                        <label for="tax_charge">ค่าภาษี <span style="color: red;">*</span></label>
                        <input type="text" id="tax_charge" name="tax_charge" ng-model="newTax.taxCharge" class="form-control">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('taxCharge')"></span>
                        <span class="help-block" ng-show="checkValidate('taxCharge')">กรุณากรอกค่าภาษี</span>
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                   <div class="form-group">
                        <label class="control-label" for="remark">หมายเหตุ</label>
                        <textarea id="remark" name="remark" cols="30" rows="5" class="form-control"></textarea>
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
                    <br><button class="btn btn-primary pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>
                </div>
            </div>

            <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
            <input type="hidden" id="vehicle_id" name="vehicle_id">
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

                $('#tax_start_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                })
                .on("dp.change", function(e) {
                    let new_date = moment(e.date, "DD-MM-YYYY").add(1, 'years');
                    console.log(new_date);
                    $('#tax_renewal_date').data('DateTimePicker').date(new_date);
                }); 

                $('#tax_renewal_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                });

                $('#doc_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                }); 

                // $("#activity").tagsinput('items')
            });
        </script>

    </div><!-- /.container -->
    @endsection
