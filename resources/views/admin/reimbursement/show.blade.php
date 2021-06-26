@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reimbursement.actions.index'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> {{ trans('admin.reimbursement.actions.index') }} No. :
                {{$data->rmb_no}}
            </div>

            <div class="card-body">
                <div class="col-6 mx-auto border p-5">
                    <div class="row">
                        <div class="col-3 text-right">
                            <img src="{{url('images/logo.png')}}" style="height:5rem" alt="">
                        </div>
                        <div class="col-6 text-center">
                            <p class="mb-0">Republic of the Philippines</p>
                            <h6 class="mb-0 ">PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY</h6>
                            <p class="mb-0">(Formerly Ramon Magsaysay Technological University)</p>
                            <p>Castillejos, Zambales, Philippines</p>
                        </div>
                        <div class="col-3 text-left">
                            <img src="{{url('images/gad.png')}}" style="height:7rem" alt="">
                        </div>
                    </div>
                    <hr class="mt-0" style="border:solid thin black">
                    <h5 class="text-center font-weight-bold mb-5">Office of Gender and Development</h5>


                    {!! $data->letter_body !!}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection