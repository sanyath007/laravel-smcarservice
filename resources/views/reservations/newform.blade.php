    @extends('layouts.main')

    @section('content')
    <div class="container-fluid" ng-controller="reserveCtrl">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บันทึกขอใช้รถ</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> บันทึกขอใช้รถ
            </span>
        </div>

        <hr />
        <!-- page title -->
        
        <form id="frmNewReserve" action="{{ url('/reserve/add') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="reserve_type">รอบการขอ</label>
                        <input type="radio" id="reserve_type" name="reserve_type" value="1"> รอบปกติ
                        <input type="radio" id="reserve_type" name="reserve_type" value="2"> รอบฉุกเฉิน  ระบุเหตุผล <input type="text" id="reserve_type_text" name="reserve_type_text" style="width: 300px;">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reserve_date">วันที่ขอ</label>
                        <input type="text" id="reserve_date" name="reserve_date" value="<?= date('Y-m-d'); ?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('activity_type')}">
                        <label class="control-label" for="activity_type">
                            ประเภทกิจกรรม <font style="color: red;">*</font>
                        </label>
                        <select id="activity_type" 
                                name="activity_type"
                                class="form-control" 
                                ng-model="newReserve.activity_type"
                                ng-change="selectedTextToActivity($event)">
                            <option value="">-- กรุณาเลือกประเภทกิจกรรม --</option>
                            <option value="1">ประชุม/อบรม/สัมมนา/ร่วมกิจกรรม</option>
                            <option value="2">ศึกษาดูงาน</option>
                            <option value="18">รับ/ส่ง ผู้ป่วย</option>
                            <option value="3">รับ/ส่ง จนท./วิทยากร/ผู้เข้าประชุมหรืออบรม</option>
                            <option value="4">รับ/ส่ง เอกสาร/หนังสือ/จดหมาย ทางราชการ</option>
                            <option value="5">รับ/ส่ง ยา/เวชภัณฑ์</option>
                            <option value="19">รับ/ส่ง วัสดุทางการแพทย์/เลือด/Specimen/LAB ฯลฯ</option>
                            <option value="6">รับ/ส่ง ครุภัณฑ์/อุปกรณ์/เครื่องมือ ฯลฯ</option>
                            <option value="7">ออกหน่วยปฐมพยาบาล</option>
                            <option value="8">เยี่ยมผู้ป่วย</option>
                            <option value="9">ให้บริการภายนอก รพ.</option>
                            <option value="10">ทำธุรกรรมที่ธนาคาร</option>
                            <option value="11">ซื้อของ</option>
                            <option value="12">ควบคุม/สอบสวนโรค</option>
                            <option value="13">ตรวจราชการ/ประเมินผลงาน</option>
                            <option value="14">รับบริจาค</option>
                            <option value="15">ดูสถานที่จัดประชุม/กิจกรรม</option>
                            <option value="16">ร่วมงานศพ</option>
                            <option value="17">ร่วมงานแต่งงาน</option>
                            <option value="99">อื่นๆ</option>
                        </select>
                        
                        <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('activity_type')"></span> -->
                        <span class="help-block" ng-show="checkValidate('activity_type')">กรุณาเลือกประเภทกิจกรรม</span>
                        
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->                

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('activity')}">
                        <label class="control-label" for="activity">
                            เพื่อไปราชการ <font style="color: red;">*</font>
                        </label>
                        <input  type="text" 
                                id="activity" 
                                name="activity"                                
                                class="form-control"
                                ng-model="newReserve.activity">
                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('activity')"></span>
                        <span class="help-block" ng-show="checkValidate('activity')">กรุณาระบุข้อมูล</span>
                    </div>
                </div>
                <!-- left column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('location')}">
                        <label class="control-label" for="location">สถานที่ <font style="color: red;">*</font></label>
                        <!--<div class="input-group">-->
                        <!--    <span class="input-group-btn">-->
                        <!--        <button type="button" class="btn btn-primary" ng-click="showNewLocationForm($event)">-->
                        <!--            <i class="fa fa-location-arrow" aria-hidden="true"></i>-->
                        <!--        </button>-->
                        <!--    </span>-->
                            <input  type="text" 
                                    id="location" 
                                    name="location" 
                                    class="form-control" 
                                    placeholder="สถานที่&hellip;"
                                    autocomplete="off">
                                    <!--ng-keyup="queryLocation($event)"-->
                                    <!--ng-keypress="enterToAddLocation($event)"-->
                        <!--</div>-->

                        <!-- <tags-input ng-model="locations"> -->
                            <!-- <auto-complete source="loadLocation($query)"></auto-complete> -->
                        <!-- </tags-input> -->
                        
                        <!--<input type="hidden" id="locationId" name="locationId" ng-model="newReserve.locationId">-->

                        <!-- Autocomplete List -->
                        <!--<div class="list-group" -->
                        <!--     style="width: auto; z-index: 10; position: absolute;" -->
                        <!--     ng-model="hidePopupLocation" -->
                        <!--     ng-hide="hidePopupLocation">-->
                        <!--    <a  class="list-group-item" -->
                        <!--        ng-repeat="(index, l) in filterLocation" -->
                        <!--        ng-click="addLocation(l)"-->
                        <!--        ng-class="{active: index == 0}">-->
                        <!--        @{{l.name}}-->
                        <!--    </a>-->
                        <!--</div>-->
                        <!-- Autocomplete List --> 

                        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('location')"></span>
                        <span class="help-block" ng-show="checkValidate('location')">กรุณาระบุสถานที่</span>                   
                    </div>                    

                    <span class="tag label label-info" ng-repeat="location in locations">
                        <span>@{{ location.name }}</span>
                        <a ng-click="removeLocation(location)">
                            <i class="remove glyphicon glyphicon-remove-sign glyphicon-white"></i>
                        </a> 
                    </span>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="dlgNewLocationForm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="">เพิ่มรายการสถานที่</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">ชื่อสถานที่</label>
                                        <input type="text" id="locationName" name="locationName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">ที่อยู่</label>
                                        <input type="text" id="locationAddress" name="locationAddress" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">ถนน</label>
                                        <input type="text" id="locationRoad" name="locationRoad" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ID">จังหวัด</label>
                                        <select 
                                            id="chw_id"
                                            name="chw_id" 
                                            class="form-control" 
                                            ng-model="selectedChangwat" 
                                            ng-change="getAmphur($event, selectedChangwat)">
                                            <option value="">-- กรุณาเลือกจังหวัด --</option>
                                            <option value="@{{ c.chw_id }}" ng-repeat="c in changwats">
                                                @{{ c.changwat }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="ID">อำเภอ</label>
                                        <select 
                                            id="amp_id"
                                            name="amp_id" 
                                            class="form-control" 
                                            ng-model="selectedAmphur"
                                            ng-change="getTambon($event, selectedAmphur)">
                                            <option value="">-- กรุณาเลือกอำเภอ --</option>
                                            <option value="@{{ a.id }}" ng-repeat="a in amphurs">
                                                @{{ a.amphur }}
                                            </option>
                                        </select>
                                    </div>                    

                                    <div class="form-group">
                                        <label for="ID">ตำบล</label>                    
                                        <select 
                                            id="tam_id"
                                            name="tam_id" 
                                            class="form-control" 
                                            ng-model="selectedTambon">
                                            <option value="">-- กรุณาเลือกตำบล --</option>
                                            <option value="@{{ t.id }}" ng-repeat="t in tambons">
                                                @{{ t.tambon }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">รหัสไปรษณี</label>
                                        <input type="text" id="locationPostcode" name="locationPostcode" class="form-control">
                                    </div>              
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" ng-click="addNewLocation($event)">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->  

                </div><!-- left column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="from_date">ใช้ระหว่างวันที่</label>
                        <input type="text" id="from_date" name="from_date" class="form-control">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="from_time">เวลา</label>
                        <input type="text" id="from_time" name="from_time" class="form-control">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="to_date">ถึงวันที่</label>
                        <input type="text" id="to_date" name="to_date" class="form-control">
                    </div>
                </div>
                <!-- left column -->
            
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="to_time">เวลา</label>
                        <input type="text" id="to_time" name="to_time" class="form-control">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->
            
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('department')}">
                        <label class="control-label" for="department">หน่วยงานผู้ขอ <font style="color: red;">*</font> </label>
                        <select id="department" 
                                name="department" 
                                ng-model="newReserve.department"
                                class="form-control">
                                <!--ng-change="getWard($event, newReserve.department)"-->
                            <option value="">-- กรุณาเลือกกลุ่มงาน --</option>
                            
                            <?php $departments = App\Department::orderBy('faction_id', 'ASC')->orderBy('depart_id', 'ASC')->get(); ?>

                            <optgroup label="กลุ่มภารกิจด้านอำนวยการ">                  
                                @foreach($departments as $department)
                                    @if ($department->faction_id == '1')
                                        <option value="{{ $department->depart_id }}">
                                            {{ $department->depart_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <!-- <optgroup label="กลุ่มภารกิจด้านบริการทุติยภูมิและตติยภูมิ">                  
                                @foreach($departments as $department)
                                    @if ($department->faction_id == '2')
                                        <option value="{{ $department->depart_id }}">
                                            {{ $department->depart_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="กลุ่มภารกิจด้านบริการปฐมภูมิ">                  
                                @foreach($departments as $department)
                                    @if ($department->faction_id == '3')
                                        <option value="{{ $department->depart_id }}">
                                            {{ $department->depart_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="กลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ">                  
                                @foreach($departments as $department)
                                    @if ($department->faction_id == '7')
                                        <option value="{{ $department->depart_id }}">
                                            {{ $department->depart_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="กลุ่มภารกิจด้านการพยาบาล">                  
                                @foreach($departments as $department)
                                    @if ($department->faction_id == '5')
                                        <option value="{{ $department->depart_id }}">
                                            {{ $department->depart_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup> -->

                        </select>
                        <span class="help-block" ng-show="checkValidate('department')">กรุณาเลือกกลุ่มงาน</span>
                    </div>         
                        
                </div>
                <!-- left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('ward')}">
                        <label class="control-label" for="ward">&nbsp;</label>
                        <select id="ward" 
                                name="ward" 
                                ng-model="newReserve.ward" 
                                class="form-control">
                            <option value="">-- กรุณาเลือกงาน --</option>
                            <option value="@{{ w.ward_id }}" ng-repeat="w in wards">
                                @{{ w.ward_name }}
                            </option>
                        </select>
                        <span class="help-block" ng-show="checkValidate('ward')">กรุณาเลือกหน่วยงานผู้จอง</span>
                    </div> -->

                    <div class="form-group">
                        <label for="reserve_user">ผู้ขอ</label>
                        <input type="text" id="reserve_user" name="reserve_user" value="" class="form-control">
                    </div>
                        
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('reserve_user_position')}">
                        <label class="control-label" for="reserve_user_position">
                            ตำแหน่งผู้ขอ <font style="color: red;">*</font>
                        </label>
                        <select id="reserve_user_position" 
                                name="reserve_user_position"
                                ng-model="newReserve.reserve_user_position"
                                class="form-control">
                            <option value="">-- กรุณาเลือกตำแหน่งผู้ขอ --</option>

                            @foreach($positions as $position)
                                <option value="1">{{ $position->position_name }}</option>
                            @endforeach
                            
                        </select>

                        <span class="help-block" ng-show="checkValidate('reserve_user_position')">กรุณาเลือกตำแหน่งผู้ขอ</span>
                        
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reserve_date">เบอร์โทรศัพท์</label>
                        <input type="text" id="reserve_user_tel" name="reserve_user_tel" value="" class="form-control">
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row --> 

            <!-- passenger -->
            <div class="row">
                <div class="col-md-6">
                    <!-- <div class="form-group"> -->
                        <!-- <label class="control-label" for="passengers">ผู้ร่วมเดินทาง</label> 
                        ( 
                            <input type="checkbox" name="chkUserIn" checked="checked"> 
                            <font style="color: red;">รวมผู้ขอ</font> 
                        )
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dlgPersons">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </button>
                            </span>
                            <input  type="text" 
                                    id="searchPassenger" 
                                    class="form-control" 
                                    placeholder="เจ้าหน้าที่&hellip;" 
                                    ng-keyup="queryPersons($event)"
                                    ng-keypress="enterToAddPassengers($event)"
                                    autocomplete="off">
                        </div> -->
                        
                        <!-- Autocomplete List -->
                        <!-- <div class="list-group" ng-model="hidethis" ng-hide="hidethis" style="width: auto; z-index: 10; position: absolute;">
                            <a  class="list-group-item" 
                                ng-repeat="(index,p) in persons" 
                                ng-click="addPassenger(p)"
                                ng-class="{active: index == 0}">
                                @{{p.name}}
                            </a>
                        </div> -->
                        <!-- Autocomplete List -->
                    <!-- </div> -->


                    <!-- Modal -->
                    <!-- <div class="modal fade" id="dlgPersons" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="">เพิ่มบุคลากร</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">ชื่อบุคลากร</label>
                                        <input type="text" name="" ng-model="product" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Modal -->  

                    <!-- <div class="table-responsive" style="height: 200px;border: 1px solid #D8D8D8;">
                        <table id="passenger-list" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10%; text-align: center;">CID</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th style="width: 20%; text-align: center;">ตำแหน่ง</th>
                                    <th style="width: 30%; text-align: center;">สังกัด</th>
                                    <th style="width: 10%; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="p in passengerList">
                                    <td style="text-align: center;">
                                        @{{p.id}}
                                    </td>
                                    <td>@{{p.name}}</td>   
                                    <td style="text-align: center;">
                                        @{{p.position}}
                                    </td>
                                    <td style="text-align: center;">
                                        @{{p.ward}}
                                    </td>
                                    <td style="text-align: center;">
                                        <a ng-click="removePassngerList(p)" style="color: red;cursor: pointer;">
                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
 -->
                    <div class="form-group">
                        <label class="control-label" for="passengerNum">จำนวนผู้ร่วมเดินทาง <!--(สามารถระบุจำนวนไม่ตรงกับรายชื่อได้)--></label>
                        <input  type="text" 
                                id="passengerNum" 
                                name="passengerNum"
                                value="1" 
                                class="form-control" 
                                placeholder="จำนวนผู้ร่วมเดินทาง&hellip;">
                    </div>
                </div><!-- end col -->

                <!-- right column -->
                <div class="col-md-6">
                    <label class="control-label" for="remark">หมายเหตุ</label>
                    <textarea id="remark" name="remark" cols="30" rows="1" class="form-control"></textarea>
                </div><!-- right column -->
            </div><!-- end row -->
            <br>
            
            <!-- page title -->
            <div class="page__title">
                <span>
                    <i class="fa fa-sticky-note-o" aria-hidden="true"></i> เพิ่มเติม
                </span>
            </div>

            <hr style="margin: 0px; margin-top: 5px; margin-bottom: 10px;" />
            <!-- page title -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'has-error has-feedback': checkValidate('transport')}">
                        <label class="control-label" for="transport">
                            ลักษณะการรับ-ส่ง <font style="color: red;">*</font>
                        </label>
                        <select id="transport" name="transport" ng-model="newReserve.transport" class="form-control">
                            <option value="">-- กรุณาเลือกลักษณะการใช้รถ --</option>
                            <option value="1">ส่งอย่างเดียว</option>
                            <option value="2">รับอย่างเดียว</option>
                            <option value="3">รับ-ส่ง (ภายในวัน)</option>
                            <option value="5">รับ-ส่ง (โดยส่งไว้ แล้วไปรับเวลากลับ)</option>
                            <option value="4">รับ-ส่ง (ต้องค้างคืน)</option>
                            <option value="6">รับ-ส่ง (ทุกวัน กรณีไปหลายวัน โดยเวลาและสถานที่เดียวกัน)</option>
                            <option value="9">ขับเอง (เฉพาะกรณีผู้ขอเป็นพนักงานขับรถสำรอง)</option>
                        </select>
                        <!-- <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate('transport')"></span> -->
                        <span class="help-block" ng-show="checkValidate('transport')">กรุณาเลือกลักษณะการรับ-ส่ง</span>
                    </div>
                </div>
                <!-- left column -->
                
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="startpoint">จุดรับ</label>
                        <input  type="text" 
                                id="startpoint" 
                                name="startpoint"
                                ng-model="newReserve.startpoint"
                                class="form-control" 
                                placeholder="ระบุจุดรับ&hellip;">
                    </div>
                </div><!-- right column -->
            </div><!-- end row -->
            
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <div class="form-group">
                        <label class="control-label" for="vehicle_type">ระบุประเภทรถ (ถ้ามี)</label>
                        <input type="radio" id="vehicle_type" name="vehicle_type" value="1"> รถกระบะ
                        <input type="radio" id="vehicle_type" name="vehicle_type" value="2"> รถตู้ 12 ที่นั่ง
                        <!-- <input type="radio" id="vehicle_type" name="vehicle_type" value="3"> รถพยาบาล -->
                    </div>

                </div>
                <!-- left column -->
            </div>  

            <!-- <div class="row"> -->
                <!-- left column -->
                <!-- <div class="col-md-12">

                    <div class="form-group">
                        <label class="control-label" for="attachfile">แนบไฟล์</label>
                        <input type="file" id="attachfile" name="attachfile" class="form-control" placeholder="สถานที่&hellip;" ng-keyup="queryLocation($event)" autocomplete="off" ng-keypress="enterToAddLocation($event)">
                    </div>

                </div> -->
                <!-- left column -->
            <!-- </div> -->


            <!-- <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <p>
                                <span>Sale Person :</span><span class="pull-right">Kobe</span>
                            </p>
                            <p>
                                <span>Sub Total :</span><span class="pull-right">@{{subTotal}}</span>
                            </p>
                            <p>
                                <span>Discount :</span>
                                <a href="#" class=" pull-right" editable-text="discount">@{{discount}}</a>
                            </p>
                            <p>
                                <span>Tax :</span>
                                <a href="#" class=" pull-right" editable-text="tax">@{{tax}}</a>
                            </p>

                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-12">
                                  <label for="" col-md-12>ชำระโดย :</label>
                                  <div data-toggle="buttons">
                                    <label type="button" class="btn btn-default active">
                                      <input type="radio" name="q1" value="0">
                                      Cash
                                    </label>
                                    <label type="button" class="btn btn-default">
                                      <input type="radio" name="q1" value="0">
                                      Credit Card
                                    </label>
                                    <label type="button" class="btn btn-default">
                                      <input type="radio" name="q1" value="0">
                                      Check
                                    </label>
                                    <label type="button" class="btn btn-default">
                                      <input type="radio" name="q1" value="0">
                                      Credit
                                    </label>
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <div class="input-group">
                                      <input type="text" class="form-control" placeholder="0.00" ng-model="total">
                                      <span class="input-group-btn">
                                        <button type="button" class="btn btn-success">
                                          <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                          จบการขาย
                                        </button>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="row" ng-show="!comment">
                                <div class="col-md-12">
                                  <i class="fa fa-comment-o" aria-hidden="true"></i>
                                  Comment :
                                  <a ng-click="comment = !comment">
                                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                  </a>
                                </div>
                            </div>

                            <div class="row" ng-show="comment">
                                <div class="col-md-12">
                                  <i class="fa fa-comment-o" aria-hidden="true"></i>
                                  Comment :
                                  <a ng-click="comment = !comment">
                                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                                  </a>

                                  <textarea name="name" rows="4" cols="80" class="form-control"></textarea>
                                  <input type="checkbox" name="" value=""> แสดงข้อความ Comment
                                </div>
                            </div>

                        </div>
                    </div> --><!-- /.panel -->

                <!-- </div> --><!-- end col -->
            <!-- </div> --><!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <br><button class="btn btn-primary pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>
                </div>
            </div>

            <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
            <input type="hidden" id="passengers" name="passengers">
            <input type="hidden" id="reserve_type" name="reserve_type" value="1">
            {{ csrf_field() }}
        </form>
        
        <script>
            $(document).ready(function($) {
                var dateNow = new Date();

                $('#from_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                })
                .on("dp.change", function(e) {
                    $('#to_date').data('DateTimePicker').date(e.date);
                });

                $('#from_time').datetimepicker({
                    useCurrent: true,
                    format: 'HH:mm',
                    defaultDate: moment(dateNow).hours(8).minutes(0).seconds(0).milliseconds(0) 
                }); 

                $('#to_date').datetimepicker({
                    useCurrent: true,
                    format: 'YYYY-MM-DD',
                    defaultDate: moment(dateNow)
                }); 

                $('#to_time').datetimepicker({
                    useCurrent: true,
                    format: 'HH:mm',
                    defaultDate: moment(dateNow).hours(16).minutes(0).seconds(0).milliseconds(0)
                });

                // $("#activity").tagsinput('items')
            });
        </script>

    </div><!-- /.container -->
    @endsection
