@extends('layouts.main')

@section('content')
<div class="container-fluid">
    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายการประวัติการบำรุงรักษารถล่าสุด</li>
    </ol>

    <!-- page title -->
    <div class="page__title">
        <span>
            รายการประวัติการบำรุงรักษารถ
            {{ $vehicle->cate->vehicle_cate_name }}
            {{ $vehicle->type->vehicle_type_name }}
            {{ $vehicle->manufacturer->manufacturer_name }}
            ทะเบียน {{ $vehicle->reg_no }} {{ $vehicle->changwat->short }}
        </span>
        
        <a href="{{ url('/maintained/vehicleprint') }}/{{ $vehicle->vehicle_id }}" class="btn btn-success pull-right">
            <i class="fa fa-print" aria-hidden="true"></i>
            print
        </a>

        <a href="{{ url('/maintained/new') }}/{{ $vehicle->vehicle_id }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            New
        </a>
    </div>

    <hr />
    <!-- page title -->
  
    <div class="row">
        <div class="col-md-12">

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="width: 5%; text-align: center;">#</th>
                        <th style="width: 8%; text-align: center;">วันที่ซ่อม</th>
                        <th style="width: 10%; text-align: center;">เลขระยะทางเมื่อเข้าซ่อม</th>
                        <th style="text-align: center;">รายละเอียด</th>
                        <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>              
                        <th style="width: 8%; text-align: center;">ค่าใช้จ่าย</th>
                        <th style="width: 12%; text-align: center;">สถานที่ซ่อม</th>
                        <th style="width: 10%; text-align: center;">ผู้แจ้ง</th>
                        <th style="width: 5%; text-align: center;">สถานะ</th>
                        <th style="width: 12%; text-align: center;">หมายเหตุ</th>
                        <th style="width: 6%; text-align: center;">Actions</th>
                    </tr>
                    @foreach($maintenances as $maintenance)
                    <tr>
                        <td style="text-align: center;">
                            {{ $maintenance->maintained_id }}
                        </td>        
                        <td style="text-align: center;">{{ $maintenance->maintained_date }}</td>
                        <td style="text-align: center;">{{ number_format($maintenance->mileage) }}</td>
                        <td>{{ $maintenance->detail }}</td>
                        <td style="text-align: center;">
                            {{ $maintenance->delivery_bill }}
                        </td>
                        <td style="text-align: center;">{{ number_format($maintenance->total,2) }}</td>
                        <td style="text-align: center;">{{ $maintenance->garage->garage_name }}</td>
                        <td style="text-align: center;">
                            {{ $maintenance->user->person_firstname }}  {{ $maintenance->user->person_lastname }}
                        </td>
                        <td style="text-align: center;">{{ $maintenance->status }}</td>
                        <td>{{ $maintenance->remark }}</td>
                        <td style="text-align: center;">
                            <a href="{{$maintenance->maintain_id}}" class="btn btn-warning btn-xs">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <a href="{{$maintenance->maintain_id}}" class="btn btn-danger btn-xs">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            
            <ul class="pagination">
                @if($maintenances->currentPage() !== 1)
                    <li>
                        <a href="{{ $maintenances->url($maintenances->url(1)) }}" aria-label="Previous">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif
                
                @for($i=1; $i<=$maintenances->lastPage(); $i++)
                    <li class="{{ ($maintenances->currentPage() === $i) ? 'active' : '' }}">
                        <a href="{{ $maintenances->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                @if($maintenances->currentPage() !== $maintenances->lastPage())
                    <li>
                        <a href="{{ $maintenances->url($maintenances->lastPage()) }}" aria-label="Previous">
                            <span aria-hidden="true">Last</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</div>
@endsection
