@extends('layouts.main')

@section('content')
<div class="container-fluid" ng-controller="reserveCtrl">
  
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการขอใช้รถ</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            <i class="fa fa-calendar" aria-hidden="true"></i> รายการขอใช้รถ
        </span>
        <a href="{{ url('/reserve/new') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            เพิ่มรายการ
        </a>
    </div>

    <hr />
    <!-- page title -->

    <!-- <form action="" method="POST" class="form-horizontal"> -->
        <!-- <div class="row">
            <div class="col-md-12">
            
                <div class="form-group"> -->
                    <!-- <label class="control-label col-sm-4" for="">ค้นหา</label> -->
                    <!-- <div class="col-sm-12"> -->
                        <!-- <div class="input-group" id="adv-search">
                            <input type="text" class="form-control" placeholder="Search&hellip;" />
                            <div class="input-group-btn">
                                <div class="btn-group" role="group">
                                    <div class="dropdown dropdown-lg">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                            <form class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label for="filter">Filter by</label>
                                                    <select class="form-control">
                                                        <option value="0" selected>All Snippets</option>
                                                        <option value="1">Featured</option>
                                                        <option value="2">Most popular</option>
                                                        <option value="3">Top rated</option>
                                                        <option value="4">Most commented</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contain">Author</label>
                                                    <input class="form-control" type="text" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="contain">Contains the words</label>
                                                    <input class="form-control" type="text" />
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </div>
                            </div>
                        </div> -->
                    <!-- </div> -->
                <!-- </div>            

            </div>        
        </div> -->
    <!-- </form> -->

    <div class="row">
        <div class="col-md-12">
            
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('/reserve/list') }}" method="GET" class="form-inline">
                        <div class="form-group">
                            <label for="">วันที่เดินทาง :</label>
                            <input type="text" id="searchdate" name="searchdate" value="{{ $searchdate }}" class="form-control">
                        </div>

                        <button class="btn btn-primary">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            แสดงตามวันที่
                        </button>
                        <a href="{{ url('/reserve/list') }}" class="btn btn-success">
                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                            แสดงทั้งหมด
                        </a>
                    </form>
                </div>                
            </div><br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 4%; text-align: center;">#</th>
                        <th style="width: 10%; text-align: center;">วันที่ขอ</th>
                        <th style="width: 15%; text-align: center;">วันเวลา ไป-กลับ</th>
                        <th style="width: 12%; text-align: center;">ผู้ขอ/โทร.</th>
                        <th style="width: 15%; text-align: center;">ไปราชการ</th>
                        <th>สถานที่ไป</th>
                        <th style="width: 6%; text-align: center;">ผู้ร่วมเดินทาง</th>
                        <th style="width: 8%; text-align: center;">รถทะเบียน</th>
                        <th style="width: 12%; text-align: center;">พขร.</th>
                        <th style="width: 8%; text-align: center;">สถานะ</th>
                        <th style="width: 10%; text-align: center;">Actions</th>
                    </tr>
                    @foreach($reservations as $reservation)
                        <?php 
                            $reserveStatus = [
                                'ยังไม่เปิดดู',
                                'รับเรื่องแล้ว',
                                'อนุมัติแล้ว',
                                'เหลืออีกเที่ยว',
                                'จบงาน',
                                'ยกเลิก'
                            ];
                            $vehicle = App\Vehicle::where(['vehicle_id' => $reservation->vehicle_id])->with('changwat')->first();
                            $driver = App\Models\Driver::where(['driver_id' => $reservation->driver_id])->with('person')->first();
                        ?>

                        <?php
                            // $locationIds = [];
                            // $locationIds = explode(",", $reservation->location);
                            // $locations = App\Location::where('id','<>','1')
                            //                 ->pluck('name','id')->toArray();

                            // $locationList = '<ul class="tag__list">';
                            // foreach ($locationIds as $key => $value) {
                            //     if (!empty($value)) {                                    
                            //         $locationList .= '                                        
                            //                 <li>
                            //                     <span class="label label-info">' .$locations[$value]. '</span>
                            //                 </li>';
                            //     }
                            // }
                            // $locationList .= '</ul>';                         
                        ?>
                    <tr <?=($reservation->status==5) ? 'class="cancel-data"' : ''?>>
                        <td style="text-align: center;">
                            <h4><span class="label label-<?= (($reservation->approved == '1') ? 'success' : (($reservation->approved == '0') ? 'default' : 'danger')) ?>">
                                {{ $reservation->id }}
                            </span></h4>
                        </td>                        
                        <td style="text-align: center;">
                            {{ $reservation->reserve_date }}
                        </td>
                        <td style="text-align: center;">
                            {{ $reservation->from_date }} {{ $reservation->from_time }}<br>
                            {{ $reservation->to_date }} {{ $reservation->to_time }}
                        </td>
                        <td style="text-align: center;">
                            <?php
                                echo $reservation->reserve_user. ' / ' .$reservation->reserve_user_tel;
                                // echo (($reservation->user) ? $reservation->user->person_firstname. ' ' .$reservation->user->person_lastname. ' / ' .$reservation->user->person_tel : ''); 
                            ?>
                        </td>
                        <td>
                            {{ $reservation->activity }}
                        </td>
                        <td>
                            {{ $reservation->location }}
                        </td>
                        <td style="text-align: center;">
                            <a class="btn btn-success btn-xs" ng-click="showPassengers($event, {{ $reservation->id }})">
                                {{ $reservation->passengers }}
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <?= (($vehicle) ? $vehicle->reg_no. ' ' .$vehicle->changwat->short : ''); ?>
                        </td>
                        <td style="text-align: center;">
                            <?= (($driver) ? $driver->description. ' / ' .$driver->tel : ''); ?>
                        </td>
                        <td style="text-align: center;">
                            <?= (($reservation->status==5) ? '<span class="label label-danger">' .$reserveStatus[$reservation->status]. '</span>' : $reserveStatus[$reservation->status]); ?>
                        </td>
                        <td style="text-align: center;">
                            @if (Auth::user()->person_id == $reservation->user_id || Auth::user()->person_id == '1300200009261' || Auth::user()->person_id == '3300101554160' || Auth::user()->person_id == '3340700927877' || Auth::user()->person_id == '1431100020874' || Auth::user()->person_id == '3300100375865' || Auth::user()->person_id == '3201000048759' || Auth::user()->person_id == '3302000684566' || Auth::user()->person_id == '1309900710679' || Auth::user()->person_id == '5301100037355')
                                @if ($reservation->status != '5')
                                    @if (Auth::user()->person_id == $reservation->user_id || Auth::user()->person_id == '1300200009261' || Auth::user()->person_id == '3300101554160' || Auth::user()->person_id == '3340700927877' || Auth::user()->person_id == '1431100020874' || Auth::user()->person_id == '3300100375865' || Auth::user()->person_id == '3201000048759' || Auth::user()->person_id == '3302000684566' || Auth::user()->person_id == '1309900710679' || Auth::user()->person_id == '5301100037355')
                                        <a  href="{{ url('/print/print.php') }} ?id={{ $reservation->id }}" 
                                            class="btn btn-success btn-xs"
                                            target="_blank"
                                            title="พิมพ์ใบขอใช้รถ">
                                            <i class="fa fa-print" aria-hidden="true"></i>
                                        </a>
                                    
                                        <a  href="{{ url('/reserve/edit/' . $reservation->id) }}" 
                                            class="btn btn-warning btn-xs"
                                            title="แก้ไขรายการ">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                
                                    @if (Auth::user()->person_id == $reservation->user_id || Auth::user()->person_id == '1300200009261' || Auth::user()->person_id == '3300101554160' || Auth::user()->person_id == '3340700927877' || Auth::user()->person_id == '1431100020874' || Auth::user()->person_id == '3300100375865' || Auth::user()->person_id == '3201000048759' || Auth::user()->person_id == '3302000684566' || Auth::user()->person_id == '1309900710679' || Auth::user()->person_id == '5301100037355')
                                        <a  href="{{ url('/reserve/cancel/' . $reservation->id) }}" 
                                            ng-click="cancel($event, {{ $reservation->id }})"
                                            class="btn btn-primary btn-xs"
                                            title="ยกเลิกรายการ">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>

                                        <form id="{{ $reservation->id }}-cancel-form" action="{{ url('/reserve/cancel') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="_id" name="_id" value="{{ $reservation->id }}">
                                        </form>
                                    @endif
                                @endif
                            @endif

                            @if (Auth::user()->person_id == '1300200009261')
                                @if ($reservation->status == '5')
                                    <a  href="{{ url('/reserve/recover/' . $reservation->id) }}" 
                                        ng-click="recover($event, {{ $reservation->id }})"
                                        class="btn btn-default btn-xs"
                                        title="นำรายการกลับมาใหม่">
                                        <i class="fa fa-retweet" aria-hidden="true"></i>
                                    </a>

                                    <form id="{{ $reservation->id }}-recover-form" action="{{ url('/reserve/recover') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="_id" name="_id" value="{{ $reservation->id }}">
                                    </form>
                                @endif

                                <a  href="{{ url('/reserve/delete/' . $reservation->id) }}" 
                                    ng-click="delete($event, {{ $reservation->id }})"
                                    class="btn btn-danger btn-xs"
                                    title="ลบรายการ">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>

                                <form id="{{ $reservation->id }}-delete-form" action="{{ url('/reserve/delete') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="_id" name="_id" value="{{ $reservation->id }}">
                                </form>

                            @endif

                            <a  class="btn btn-info btn-xs"
                                ng-click="showDetail({{ $reservation->id }})"
                                title="ดูรายละเอียด">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
            <ul class="pagination">
                @if($reservations->currentPage() !== 1)
                    <li>
                        <a href="{{ $reservations->url($reservations->url(1)).'&searchdate='.$searchdate }}" aria-label="First">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif

                <li class="{{ ($reservations->currentPage() === 1) ? 'disabled' : '' }}">
                    <a href="{{ $reservations->url($reservations->currentPage() - 1).'&searchdate='.$searchdate }}" aria-label="Prev">
                        <span aria-hidden="true">Prev</span>
                    </a>
                </li>
                
                @for($i=$reservations->currentPage(); $i < $reservations->currentPage() + 10; $i++)
                    @if ($reservations->currentPage() <= $reservations->lastPage() && ($reservations->lastPage() - $reservations->currentPage()) > 10)
                        <li class="{{ ($reservations->currentPage() === $i) ? 'active' : '' }}">
                            <a href="{{ $reservations->url($i).'&searchdate='.$searchdate }}">
                                {{ $i }}
                            </a>
                        </li> 
                    @else
                        @if ($i <= $reservations->lastPage())
                            <li class="{{ ($reservations->currentPage() === $i) ? 'active' : '' }}">
                                <a href="{{ $reservations->url($i).'&searchdate='.$searchdate }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endif
                @endfor
                
                @if ($reservations->currentPage() < $reservations->lastPage() && ($reservations->lastPage() - $reservations->currentPage()) > 10)
                    <li>
                        <a href="{{ $reservations->url($reservations->currentPage() + 10).'&searchdate='.$searchdate }}">
                            ...
                        </a>
                    </li>
                @endif
                
                <li class="{{ ($reservations->currentPage() === $reservations->lastPage()) ? 'disabled' : '' }}">
                    <a href="{{ $reservations->url($reservations->currentPage() + 1).'&searchdate='.$searchdate }}" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </a>
                </li>

                @if($reservations->currentPage() !== $reservations->lastPage())
                    <li>
                        <a href="{{ $reservations->url($reservations->lastPage()).'&searchdate='.$searchdate }}" aria-label="Last">
                            <span aria-hidden="true">Last</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
        <!-- right column -->
    </div><!-- /.row -->
    
    <!-- Modal -->
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
    <!-- Modal -->   

    <!-- Modal -->
    <div class="modal fade" id="dlgReservations" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">รายละเอียดการขอใช้รถ</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 8%; text-align: right;">ID :</th>
                                    <td>@{{ reservation.id }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 8%; text-align: right;">ผู้ขอ :</th>
                                    <td>
                                        @{{ reservation.user.person_firstname + '  ' + reservation.user.person_lastname }}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">ประเภท</th>
                                    <td>@{{ activityType[reservation.activity_type] }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">เพื่อราชการ :</th>
                                    <td>@{{ reservation.activity }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">สถานที่ :</th>
                                    <td>@{{ strLocation }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">วันที่ไป :</th>
                                    <td>@{{ reservation.from_date + ' ' + reservation.from_time }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">วันที่กลับ :</th>
                                    <td>@{{ reservation.to_date + ' ' + reservation.to_time }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">ลักษณะการรับ-ส่ง :</th>
                                    <td>@{{ transport[reservation.transport] }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; text-align: right;">หมายเหตุ :</th>
                                    <td>@{{ reservation.remark }}</td>
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
    <!-- Modal -->   

    <!-- The actual modal template, just a bit o bootstrap -->
    <script type="text/ng-template" id="modal.html">
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="">เพิ่มบุคลากร</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
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
                                    <tr ng-repeat="passenger in passengers">
                                        <td>@{{ passenger.person_id }}</td>
                                        <td>@{{ passenger.user }}</td>
                                        <td>@{{ passenger.user }}</td>
                                        <td>@{{ passenger.user }}</td>
                                        <td>@{{ passenger.user }}</td>
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
    </script> 

</div><!-- /.container -->

<script>
    $(document).ready(function($) {
        var dateNow = new Date();

        $('#searchdate').datetimepicker({
            useCurrent: true,
            format: 'YYYY-MM-DD',
            defaultDate: moment(dateNow)
        });
    });
</script>

@endsection
