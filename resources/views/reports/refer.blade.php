@extends('layouts.main')

@section('content')
<div class="container-fluid" ng-controller="reportCtrl" ng-init="getReferData()">
  
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a href="#">รายงาน</a></li>
        <li class="breadcrumb-item active">รายงานการให้บริการให้บริการรับ-ส่งต่อผู้ป่วย</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            <i class="fa fa-calendar" aria-hidden="true"></i> รายงานการให้บริการให้บริการรับ-ส่งต่อผู้ป่วย
        </span>
    </div>

    <hr />
    <!-- page title -->

    <div class="row">
        <div class="col-md-12">
            <form class="form-inline">
                <div class="form-group">
                    <label>เดือน :</label>
                    <input id="selectMonth" name="selectMonth" class="form-control"></input>
                </div>

                <button ng-click="getReferData()" class="btn btn-primary">แสดง</button>
            </form>

            <div id="barContainer" style="width: 800px; height: 400px; margin: 0 auto; margin-top: 20px;"></div>

        </div>
        <!-- right column -->
    </div><!-- /.row --> 
    
    <script>
        $(document).ready(function($) {
            var dateNow = new Date();
            
            $('#selectMonth').datetimepicker({
                useCurrent: true,
                format: 'YYYY-MM',
                defaultDate: moment(dateNow)
            })
            // .on("dp.change", function(e) {
            //     $('#to_date').data('DateTimePicker').date(e.date);
            // });
        });
    </script>
</div><!-- /.container -->
@endsection
