@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- page title -->
    <div class="page__title">
        <span>รายการรถ</span>
        <a href="{{ url('/vehicles/new') }}" class="btn btn-primary pull-right">
            <i class="fa fa-plus" aria-hidden="true"></i>
            New
        </a>
    </div>

    <hr />
    <!-- page title -->
  
    <div class="row">
        <div class="col-md-12">

            @foreach($vehicles as $vehicle)
                <?php $tax_expired = '<font style="color: red;">หมดอายุ</font>'; ?>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-inverse card-info">
                        <img class="card-img-top" src="{{ ($vehicle->thumbnail) ? url('/').'/uploads/vehicles/' .$vehicle->thumbnail : url('/').'/uploads/no-image-300x300.jpg' }}">
                        
                        <div class="card-block">
                            <!-- <figure class="profile">
                                <img src="{{ url('/').'/uploads/no-image-300x300.jpg' }}" class="profile-avatar" alt="">
                            </figure> -->

                            <h4 class="card-title mt-3">
                                <span class="label label-primary">{{ $vehicle->vehicle_no }}</span> 
                                {{ $vehicle->reg_no }} 
                                {{ $vehicle->changwat->short }}
                            </h4>
                            <!-- <div class="meta card-text">
                                <a>Friends</a>
                            </div> -->
                            <div class="card-text">
                                {{ $vehicle->cate->vehicle_cate_name }} <b>ใช้งาน</b> {{ $vehicle->type->vehicle_type_name }} <br>
                                <b>ยี่ห้อ</b> {{ $vehicle->manufacturer->manufacturer_name }}
                                <b>รุ่น</b> {{ $vehicle->model }} ปี {{ $vehicle->year }} <br>
                                <b>เครื่องยนต์</b> {{ $vehicle->fuel->fuel_type_name }} - ซีซี
                                <b>สี</b> {{ $vehicle->color }} <br>                            
                                <b>วันที่จดทะเบียน</b> {{ $vehicle->reg_date }} <br>
                                <b>วันที่หมดภาษี</b> 
                                    <?= ((count($vehicle->taxactived) > 0) ? (($vehicle->taxactived[0]->tax_renewal_date < date('Y-m-d')) ? $tax_expired : $vehicle->taxactived[0]->tax_renewal_date) : '-'); ?> <br>
                                {{ $vehicle->remark }}                            
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <a href="{{ url('/vehicle'). '/' .$vehicle->vehicle_id }}" class="btn btn-warning btn-xs">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <a href="{{ url('/vehicle'). '/' .$vehicle->vehicle_id }}" class="btn btn-danger btn-xs">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">            
            <ul class="pagination">
                @if($vehicles->currentPage() !== 1)
                    <li>
                        <a href="{{ $vehicles->url($vehicles->url(1)) }}" aria-label="Previous">
                            <span aria-hidden="true">First</span>
                        </a>
                    </li>
                @endif
                
                @for($i=1; $i<=$vehicles->lastPage(); $i++)
                    <li class="{{ ($vehicles->currentPage() === $i) ? 'active' : '' }}">
                        <a href="{{ $vehicles->url($i) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                @if($vehicles->currentPage() !== $vehicles->lastPage())
                    <li>
                        <a href="{{ $vehicles->url($vehicles->lastPage()) }}" aria-label="Previous">
                            <span aria-hidden="true">Last</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

</div>
@endsection
