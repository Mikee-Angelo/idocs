@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reimbursement.actions.index'))

@section('body')

<reimbursement-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/reimbursements') }}'"
        inline-template>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/reimbursements/'.$data['id'].'/export') }}" role="button"><i class="fa fa-file-pdf-o"></i>&nbsp; {{ trans('admin.gad-plan.actions.export') }}</a>
                
                @if($data->status == 0 && Auth::user()->roles()->pluck('id')[0] == 1)
                    <form @submit.prevent="reimbursementStatus('{{$data['id']}}/change-status', true)">
                        <button type="submit"  class="btn btn-success  btn-sm pull-right m-b-0 text-white ml-2" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-check"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.accept') }}</button>
                    </form>
                    <form @submit.prevent="reimbursementStatus('{{$data['id']}}/change-status', false)">
                        <button type="submit" class="btn btn-danger btn-sm pull-right m-b-0  text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-close"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.decline') }}</button>
                    </form>
                @endif

                <i class="fa fa-align-justify"></i> {{ trans('admin.reimbursement.actions.index') }} No. :
                {{$data->rmb_no}}
            </div>

            <div class="card-body">
                <h5>Status:  

                    @if($data->status == 0)
                        <span class="badge badge-pill badge-warning">Pending</span>
                    @elseif($data->status == 1)
                        <span class="badge badge-pill badge-success text-white">Approved</span>
                    @elseif($data->status == 2)
                        <span class="badge badge-pill badge-danger text-white">Declined</span>
                    @endif
                </h5>
                <div class="col-12 mx-auto border p-5">
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
</reimbursement-listing>

@endsection