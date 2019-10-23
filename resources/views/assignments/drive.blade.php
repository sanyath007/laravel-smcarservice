@extends('layouts.main')

@section('content')
<div class="container-fluid" ng-controller="assignCtrl">
  
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการวิ่งรถ</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            <i class="fa fa-calendar" aria-hidden="true"></i> รายการวิ่งรถ
        </span>
        <!-- <a href="{{ url('/reserve/new') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            เพิ่มรายการ
        </a> -->
    </div>

    <hr />
    <!-- page title -->

    <div class="row">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ url('/assign/drive') }}" method="GET" class="form-inline">
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
            </div><br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 4%; text-align: center;">#</th>
                        <th style="width: 12%; text-align: center;">วันเดินทาง</th>
                        <th>รายละเอียดการขอใช้รถ</th>
                        <th style="width: 8%; text-align: center;">รถทะเบียน</th>
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
                                    $locationIds = [];
                                    $locationList = '';
                                    $locationIds = explode(",", $reservation->location);
                                    $locations = App\Location::where('id','<>','1')
                                                    ->pluck('name','id')->toArray();
                                    // print_r($locations);
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
                                        </span>

                                        <span class="label label-{{ ($reserve->times=='1') ? 'warning' : 'success' }}" ng-show="{{ ($reservation->transport == 5) ? true : false }}">
                                            {{ ($reserve->times=='1') ? 'เที่ยวไป' : 'เที่ยวกลับ' }}
                                        </span><br>

                                        <b>ณ</b> <?= $locationList ?><br>
                                        <b>วันเวลาไป-กลับ</b> {{ $reservation->from_date }} {{ $reservation->from_time }} - {{ $reservation->to_date }} {{ $reservation->to_time }}<br>                      
                                        <b>จำนวนผู้โดยสาร</b> <a ng-click="showPassengers($event, {{ $reservation->id }})" class="btn btn-primary btn-xs">
                                            {{ $reservation->passengers }}
                                        </a> ราย ( <b>ผู้ขอ</b> {{ $reservation->user->person_firstname. ' ' .$reservation->user->person_lastname. ' / ' .$reservation->user->person_tel }} )
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
                            <a  ng-click="formMileage($event,{{ $assignment->id }},'/assign/drivedeparted','{{ $assignment->start_time }}')"
                                ng-disabled="{{ ($assignment->start_time) ? true : false }}"
                                class="btn btn-primary" title="ออกเดินทาง">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </a>

                            <a  ng-click="formMileage($event,{{ $assignment->id }},'/assign/drivearrived','{{ $assignment->end_time }}')"
                                ng-disabled="{{ ($assignment->end_time) ? true : false }}"
                                class="btn btn-success" title="มาถึงแล้ว">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
            <ul class="pagination">
                @if($assignments->currentPage() !== 1)
                    <li>
                        <a href="{{ $assignments->url($assignments->url(1)) }}" aria-label="Previous">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif

                <li class="{{ ($assignments->currentPage() === 1) ? 'disabled' : '' }}">
                    <a href="{{ $assignments->url($assignments->currentPage() - 1) }}" aria-label="Prev">
                        <span aria-hidden="true">Prev</span>
                    </a>
                </li>
                
                @for($i=$assignments->currentPage(); $i < $assignments->currentPage() + 10; $i++)
                    @if ($assignments->currentPage() <= $assignments->lastPage() && ($assignments->lastPage() - $assignments->currentPage()) > 10)
                        <li class="{{ ($assignments->currentPage() === $i) ? 'active' : '' }}">
                            <a href="{{ $assignments->url($i) }}">
                                {{ $i }}
                            </a>
                        </li> 
                    @else
                        @if ($i <= $assignments->lastPage())
                            <li class="{{ ($assignments->currentPage() === $i) ? 'active' : '' }}">
                                <a href="{{ $assignments->url($i) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endif
                @endfor

                <li class="{{ ($assignments->currentPage() === $assignments->lastPage()) ? 'disabled' : '' }}">
                    <a href="{{ $assignments->url($assignments->currentPage() + 1) }}" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </a>
                </li>

                @if($assignments->currentPage() !== $assignments->lastPage())
                    <li>
                        <a href="{{ $assignments->url($assignments->lastPage()) }}" aria-label="Previous">
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
    <div class="modal fade" id="dlgMileage" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">บันทึกเลขไมล์</h4>
                </div>
                <div class="modal-body">
                    <form id="mileage-form" action="" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="url" name="url">
               
                        <div class="form-group">
                            <label class="control-label" for="_date">วันที่</label>
                            <input type="text" id="_date" name="_date" class="form-control">
                        </div>                
                        <div class="form-group">
                            <label class="control-label" for="_time">เวลา</label>
                            <input type="text" id="_time" name="_time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">เลขไมล์</label>
                            <input type="text" id="mileage" name="mileage" class="form-control">
                        </div> 
                    </form>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="saveMileage()">
                        Save
                    </button>

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
    
    <script>
        $(document).ready(function($) {
            var dateNow = new Date();
            
            $('#_date').datetimepicker({
                useCurrent: true,
                format: 'YYYY-MM-DD',
                defaultDate: moment(dateNow)
            })
            // .on("dp.change", function(e) {
            //     $('#to_date').data('DateTimePicker').date(e.date);
            // });

            $('#_time').datetimepicker({
                useCurrent: true,
                format: 'HH:mm',
                defaultDate: moment(dateNow).hours(8).minutes(0).seconds(0).milliseconds(0) 
            });
        });
    </script>
</div><!-- /.container -->

<script>
    $(document).ready(function($) {
        var dateNow = new Date();

        $('#fromdate').datetimepicker({
            useCurrent: true,
            format: 'YYYY-MM-DD',
            defaultDate: moment(dateNow)
        });
    });
</script>

@endsection
