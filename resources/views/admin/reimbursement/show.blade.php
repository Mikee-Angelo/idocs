@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reimbursement.actions.index'))

@section('body')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/reimbursements/'.$data['id'].'/export') }}" role="button"><i class="fa fa-file-pdf-o"></i>&nbsp; {{ trans('admin.gad-plan.actions.export') }}</a>
                
                <i class="fa fa-align-justify"></i> {{ trans('admin.reimbursement.actions.index') }} No. :
                {{$data->rmb_no}}
            </div>

            <div class="card-body">
                <div class="col-8 mx-auto border p-5">
                    <div class="row">
                        <div class="col-3 text-right">
                            <img src="{{url('public/images/logo.png')}}" style="height:5rem" alt="">
                        </div>
                        <div class="col-6 text-center">
                            <p class="mb-0">Republic of the Philippines</p>
                            <h6 class="mb-0 ">PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY</h6>
                            <p class="mb-0">(Formerly Ramon Magsaysay Technological University)</p>
                            <p>{{$data->admin_user->user_school->letter_header}}</p>
                        </div>
                        <div class="col-3 text-left">
                            <img src="{{url('public/images/gad.png')}}" style="height:7rem" alt="">
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