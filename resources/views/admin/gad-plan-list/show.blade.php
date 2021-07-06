@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.gad-plan-list.actions.index'))

@section('body')
    <gad-plan-list-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/gad-plan-lists') }}'"
        inline-template>
 <div class="row">
  
        <div class="col">
            <div class="card">
                <div class="card-header">     
                    <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/gad-plans/'.$data[0]['id'].'/export') }}" role="button"><i class="fa fa-file-pdf-o"></i>&nbsp; {{ trans('admin.gad-plan.actions.export') }}</a>
                    @if($data[0]->gad_plan->status > 1 && Auth::user()->roles()->pluck('id')[0] == 1)
                        <form @submit.prevent="changeStatus('change-status', true)">
                            <button type="submit"  class="btn btn-success  btn-sm pull-right m-b-0 text-white ml-2" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-check"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.accept') }}</button>
                        </form>
                        <form @submit.prevent="changeStatus('change-status', false)">
                            <button type="submit" class="btn btn-danger btn-sm pull-right m-b-0 text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-close"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.decline') }}</button>
                        </form>
                    @endif
                    ANNUAL GENDER AND DEVELOPMENT (GAD) PLAN AND BUDGET {{$data[0]->gad_plan->implement_year}}
                </div>

                <div class="body">
                    <div class="card-block">
                    <div class="row">
                        <div class="col-3 text-right">
                            <img src="{{url('public/images/logo.png')}}" style="height:5rem" alt="">
                        </div>
                        <div class="col-6 text-center">
                            <p class="mb-0">Republic of the Philippines</p>
                            <h6 class="mb-0 ">PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY</h6>
                            <p class="mb-0">(Formerly Ramon Magsaysay Technological University)</p>
                            <p>{{$data[0]->gad_plan->admin_user->user_school->letter_header}}</p>
                        </div>
                        <div class="col-3 text-left">
                            <img src="{{url('public/images/gad.png')}}" style="height:7rem" alt="">
                        </div>
                    </div>
                    <hr class="mt-0" style="border:solid thin black">
                    <h5 class="text-center font-weight-bold mb-5">ANNUAL GENDER AND DEVELOPMENT (GAD) PLAN AND BUDGET {{$data[0]->gad_plan->implement_year}}</h5>
                    
                        <p>Total GAA of Agency: <span class="font-weight-bold pl-3">PHP {{number_format($sum)}}</span> </p>
                        <table class="table table-hover table-listing table-bordered table-responsive ">
                                <thead>
                                    <tr>
                                        <th >{{ trans('admin.gad-plan-list.columns.gad_issue_mandate') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.cause_of_issue') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.gad_statement_objective') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.relevant_agencies') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.gad_activity') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.indicator_target') }}</th>
                                        <th >{{ trans('admin.gad-plan-list.columns.budget_requirement') }}</th>
                                        <th>{{ trans('admin.gad-plan-list.columns.budget_source') }}</th>
                                </thead>
                                 <tbody>
                                     @foreach($data as $d)
                                        <tr>
                                            <td>{{$d['gad_issue_mandate']}}</td>
                                            <td>{{$d['cause_of_issue']}}</td>
                                            <td>{{$d['gad_statement_objective']}}</td>
                                            <td>{{$d->relevant_agency->name}}</td>
                                            <td>{{$d['gad_activity']}}</td>
                                            <td>{{$d['indicator_target']}}</td>
                                            <td>{{number_format($d['budget_requirement'])}}</td>
                                            <td >{{$d['budget_source']}}</td>
                                        </tr>
                                     @endforeach
                                 </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 </div>
 
    </gad-plan-list-listing>

@endsection