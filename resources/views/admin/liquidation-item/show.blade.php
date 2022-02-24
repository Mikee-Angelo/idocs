
@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.liquidation-item.actions.index'))

@section('body')
    <liquidation-item-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/liquidation-items') }}'"
        inline-template>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">

                @if($data->status == 0)
                    @if(Auth::user()->roles()->pluck('id')[0] == 2)
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 mr-2"
                            href="{{ url('admin/liquidations/'.$id.'/items/create') }}" role="button"><i
                        class="fa fa-plus"></i>&nbsp; {{ trans('admin.liquidation-item.actions.create') }}</a>

                        @if(count($data->liquidation_items) > 0)
                            <form @submit.prevent="liquidationSubmit('submit')">
                                <button type="submit" class="btn btn-success btn-sm pull-right m-b-0 mr-2 text-white"
                                    title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i
                                        class="fa fa-send"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.submit') }}</button>
                            </form>
                            
                        @endif
                    @endif

                @else 
                    <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/liquidations/'.$data['id'].'/export') }}" role="button"><i class="fa fa-file-pdf-o"></i>&nbsp; {{ trans('admin.gad-plan.actions.export') }}</a>
                    @if($data->status == 1  && Auth::user()->roles()->pluck('id')[0] == 1)
                        <form @submit.prevent="liquidationStatus('change-status', true)">
                            <button type="submit"  class="btn btn-success  btn-sm pull-right m-b-0 text-white ml-2" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-check"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.accept') }}</button>
                        </form>
                        <form @submit.prevent="liquidationStatus('change-status', false)">
                            <button type="submit" class="btn btn-danger btn-sm pull-right m-b-0  text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-close"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.decline') }}</button>
                        </form>
                    @endif
                @endif
              
            
                <i class="fa fa-align-justify"></i> {{ trans('admin.liquidation-item.actions.index') }}

            </div>

            <div class="card-body">

                <h5>Status:  

                        @if($data->status == 0)
                            <span class="badge badge-pill badge-primary">Draft</span> 
                        @elseif($data->status == 1)
                            <span class="badge badge-pill badge-warning">Pending</span>
                        @elseif($data->status == 2)
                            <span class="badge badge-pill badge-success text-white">Approved</span>
                        @elseif($data->status == 3)
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
                    <h5 class="text-center font-weight-bold mb-5">SUMMARY OF ITEMS</h5>
                    <h5 class="text-center mb-5">Purpose: {{$data->purpose}}</h5>

                    <table class="table table-hover table-listing table-bordered">
                        <thead>
                            <th>{{ trans('admin.liquidation-item.columns.date_acquired') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.receipt_no') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.supplier') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.unit') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.item') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.qty') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.price') }}</th>
                            <th>{{ trans('admin.liquidation-item.columns.subtotal') }}</th>
                        </thead>
                        <tbody>
                            <?php $total = 0 ?>
                            @foreach($data->liquidation_items as $k =>  $d)

                                <?php $total += $d['total'] ?>
                                <tr>
                                    <td>{{$d['date_acquired']}}</td>
                                    <td>{{$d['receipt_no']}}</td>
                                    <td>{{$d['supplier']}}</td>
                                    <td>{{$d['unit']}}</td>
                                    <td>{{$d['item']}}</td>
                                    <td>{{$d['qty']}}</td>
                                    <td>₱ {{number_format($d['price'])}}</td>
                                    <td>₱ {{number_format($d['total'])}}</td>
                                </tr>
                                @if($k == count($data->liquidation_items) - 1)
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="font-weight-bold">Total:</td>
                                    <td>₱ {{$total}}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    </liquidation-item-listing>
@endsection
