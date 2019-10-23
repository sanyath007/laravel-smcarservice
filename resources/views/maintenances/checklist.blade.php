@extends('layouts.main')

@section('content')
<div class="container-fluid" ng-controller="maintainedCtrl">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการตรวจเช็ครถ</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            <i class="fa fa-calendar" aria-hidden="true"></i> รายการตรวจเช็ครถ
        </span>
        <a href="{{ url('/maintained/checkform/1') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            เพิ่มรายการ
        </a>
    </div>

    <hr />
    <!-- page title -->
  
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">เดือน ปี</label>
                        <input type="text" id="check_date" name="check_date" class="form-control">
                    </div>
                </div>
                <!-- left column -->
        
                <!-- right column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="vehicle">รถ</label>
                        <select id="vehicle" 
                                name="vehicle"
                                class="form-control"
                                ng-model="selectedVehicle"
                                ng-change="renderTable()">
                            <option value="">-- กรุณาเลือกรถ --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->vehicle_id }}">
                                    {{ $v->cate->vehicle_cate_name }} 
                                    {{ $v->type->vehicle_type_name }}
                                    {{ $v->manufacturer->manufacturer_name }}
                                    {{ $v->model }}
                                    ทะเบียน {{ $v->reg_no }} {{ $v->changwat->short }}
                                    {{ ($v->remark) ? '(' .$v->remark. ')': '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- right column -->
            </div><!-- end row -->

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 4%; text-align: center;">#</th>
                        <th>รายการตรวจเช็ครถ</th>
                         <th style="width: 3%; text-align: center;" ng-repeat="(index, d) in date">
                            @{{ d }}
                        </th>
                    </tr>
                    
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>ล้อ และลมยาง ทั้ง 5 ล้อ</td>    
                        <td style="text-align: center;" ng-repeat="(index, tires) in tiresList">
                            <!-- <a data-toggle="popover" data-content="@{{ tires.text }}" data-trigger="hover"> -->
                            <a ng-mouseover="checkListPopup(tires)">
                                @{{ tires.state }}
                            </a>
                            <div class="popup">
                                <span class="popuptext" id="myPopup">A Simple Popup!</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">2</td>
                        <td>รอยรั่วน้ำมันใต้ท้องรถ</td>    
                        <td style="text-align: center;" ng-repeat="(index, leak) in leakList">
                            <!-- <a data-toggle="popover" data-content="@{{ leak.text }}" data-trigger="hover"> -->
                            <a ng-mouseover="checkListPopup(leak)">
                                @{{ leak.state }}
                            </a>
                            <div class="popup">
                                <span class="popuptext" id="myPopup">A Simple Popup!</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">3</td>
                        <td>หม้อน้ำ และระดับน้ำ</td>    
                        <td style="text-align: center;" ng-repeat="(index, radiator) in radiatorList">
                            <a data-toggle="popover" data-content="@{{ radiator.text }}" data-trigger="hover">
                                @{{ radiator.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">4</td>
                        <td>น้ำมันหล่อลื่น</td>    
                        <td style="text-align: center;" ng-repeat="(index, oil) in oilList">
                            <a data-toggle="popover" data-content="@{{ oil.text }}" data-trigger="hover">
                                @{{ oil.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">5</td>
                        <td>เบรก/ครัช และน้ำมันเบรก/ครัช</td>    
                        <td style="text-align: center;" ng-repeat="(index, brakeClutch) in brakeClutchList">
                            <!-- <a data-toggle="popover" data-content="@{{ brakeClutch.text }}" data-trigger="hover"> -->
                            <a ng-mouseover="checkListPopup(brakeClutch)">
                                @{{ brakeClutch.state }}
                            </a>
                            <div class="popup">
                                <span class="popuptext" id="myPopup">A Simple Popup!</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">6</td>
                        <td>แบตเตอรี่ และน้ำกลั่น</td>    
                        <td style="text-align: center;" ng-repeat="(index, battery) in batteryList">
                            <a data-toggle="popover" data-content="@{{ battery.text }}" data-trigger="hover">
                                @{{ battery.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">7</td>
                        <td>ใบปัดน้ำฝน และน้ำยาฉีดกระจก</td>    
                        <td style="text-align: center;" ng-repeat="(index, windshield) in windshieldList">
                            <a data-toggle="popover" data-content="@{{ windshield.text }}" data-trigger="hover">
                                @{{ windshield.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">8</td>
                        <td>ปริมาณน้ำมันเชื้อเพลิง</td>    
                        <td style="text-align: center;" ng-repeat="(index, fuel) in fuelList">
                            <a data-toggle="popover" data-content="@{{ fuel.text }}" data-trigger="hover">
                                @{{ fuel.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">9</td>
                        <td>การทำงานมาตรวัดต่างๆ</td>    
                        <td style="text-align: center;" ng-repeat="(index, gauges) in gaugesList">
                            <a data-toggle="popover" data-content="@{{ gauges.text }}" data-trigger="hover">
                                @{{ gauges.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">10</td>
                        <td>ไฟสัญญาณและไฟส่องสว่าง</td>    
                        <td style="text-align: center;" ng-repeat="(index, lights) in lightsList">
                            <a data-toggle="popover" data-content="@{{ lights.text }}" data-trigger="hover">
                                @{{ lights.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">11</td>
                        <td>ออกซิเจน <span style="color: red;">(เฉพาะรถพยาบาล)</span></td>    
                        <td style="text-align: center;" ng-repeat="(index, oxygen) in oxygenList">
                            <a data-toggle="popover" data-content="@{{ oxygen.text }}" data-trigger="hover">
                                @{{ oxygen.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">12</td>
                        <td>ระบบสัญญาณไซเรน <span style="color: red;">(เฉพาะรถพยาบาล)</span></td>    
                        <td style="text-align: center;" ng-repeat="(index, siren) in sirenList">
                            <a data-toggle="popover" data-content="@{{ siren.text }}" data-trigger="hover">
                                @{{ siren.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">13</td>
                        <td>ระบบวิทยุสื่อสาร <span style="color: red;">(เฉพาะรถพยาบาล)</span></td>    
                        <td style="text-align: center;" ng-repeat="(index, radio) in radioList">
                            <a data-toggle="popover" data-content="@{{ radio.text }}" data-trigger="hover">
                                @{{ radio.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">14</td>
                        <td>ร่องรอยเสียหายบริเวณตัวรถ</td>    
                        <td style="text-align: center;" ng-repeat="(index, damage) in damageList">
                            <a data-toggle="popover" data-content="@{{ damage.text }}" data-trigger="hover">
                                @{{ damage.state }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;">15</td>
                        <td>ล้างรถ</td>    
                        <td style="text-align: center;" ng-repeat="(index, isWashed) in isWashedList">
                            <a data-toggle="popover" data-content="@{{ isWashed.text }}" data-trigger="hover">
                                @{{ isWashed.state }}
                            </a>
                        </td>
                    </tr>
                    
                </table>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function($) {
            var dateNow = new Date();

            $('#check_date').datetimepicker({
                useCurrent: true,
                defaultDate: moment(dateNow),
                viewMode: 'years',
                format: 'YYYY-MM'
            });
        });
    </script>

</div>
@endsection
