@extends('layouts.main')

@section('content')
    <div class="container-fluid" ng-controller="assignCtrl">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">บันทึกการประเมินความพึงพอใจ</li>
        </ol>

        <!-- page title -->
        <div class="page__title">
            <span>
                <i class="fa fa-calendar-plus-o" aria-hidden="true"></i> บันทึกการประเมินความพึงพอใจ
            </span>
            <a href="{{ url('assess/sendmail') }}" class="btn btn-info">Send E-mail</a>
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
                                <label class="control-label" for="assign_date">วันที่ขอใช้รถ</label>
                                <input type="text" id="reserve_date" name="reserve_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive"">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ประเด็นความพึงพอใจ</th>
                                    <th style="width: 5%; text-align: center;">ดีมาก</th>
                                    <th style="width: 5%; text-align: center;">ดี</th>
                                    <th style="width: 5%; text-align: center;">ปานกลาง</th>
                                    <th style="width: 5%; text-align: center;">น้อย</th>
                                    <th style="width: 5%; text-align: center;">ควรปรับปรุง</th>
                                    <th style="width: 20%; text-align: center;">หากมีข้อเสนอแนะโปรดระบุ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; margin-left: 10px;">
                                        ด้านสภาพยานพาหนะ                                  
                                    </td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        1. สภาพของยานพาหนะ                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        2. ความสะอาดภายในยานพาหนะ                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        3. ระบบปรับอากาศในยานพาหนะ                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 10px;">
                                        ด้านพนักงานขับรถ                                  
                                    </td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        1. การนัดหมาย ตรงต่อเวลา                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        2. การแต่งกาย                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        3. มารยาทในการขับขี่ และความปลอดภัย                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        4. การใช้วาจา มารยาทของพนักงานขับรถ                                  
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; margin-left: 20px;">
                                        5. ความกระตือรือร้นในการให้บริการ
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="radio">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="text" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="depart_date">ข้อเสนอแนะอื่น ๆ</label>
                                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- left column -->                   
                        
                    </div><!-- end row -->

                    <button class="btn btn-primary pull-right" ng-click="formValidate($event)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                    </button>

                    {{ csrf_field() }}
                    <input type="hidden" id="overall" name="overall">
                    <input type="hidden" id="reserveid" name="reserveid" value="{{ str_random(30) }}">

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