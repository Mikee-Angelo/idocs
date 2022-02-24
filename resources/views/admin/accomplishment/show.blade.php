@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reimbursement.actions.index'))

@section('body')
<accomplishment-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/accomplishments') }}'"
        inline-template>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">

                
                    <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/accomplishments/'.$data['id'].'/export') }}" role="button"><i class="fa fa-file-pdf-o"></i>&nbsp; {{ trans('admin.gad-plan.actions.export') }}</a>
                    
                    <!-- @if($data->status == 0 && Auth::user()->roles()->pluck('id')[0] == 1)
                        <form @submit.prevent="accomplishmentStatus('{{$data['id']}}/change-status', true)">
                            <button type="submit"  class="btn btn-success  btn-sm pull-right m-b-0 text-white ml-2" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-check"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.accept') }}</button>
                        </form>
                        <form @submit.prevent="accomplishmentStatus('{{$data['id']}}/change-status', false)">
                            <button type="submit" class="btn btn-danger btn-sm pull-right m-b-0  text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-close"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.decline') }}</button>
                        </form>
                    @endif -->

                    <i class="fa fa-align-justify"></i> {{ trans('admin.accomplishment.actions.index') }} 
                </div>

                <div class="card-body">
                    <div class="col-6 mx-auto">
                        <h5>{{ $data->header }}</h5>

                        {!! $data->description !!}
                        <hr>
                        <h4 class="mb-5 mt-5">Gallery</h4>
                        <div class="row">
                        @foreach($data->getMedia('gallery') as $img)
                            <a href="{{$img->getUrl()}}" class="col border mx-2 my-2" style="height:15rem; background: url({{$img->getUrl()}}); background-repeat: no-repeat; background-position: center; background-size: contain;"></a>       
                         @endforeach
                        </div>
    
                        {{-- <img v-for="item in {{$data->getMedia('gallery')}}" :key="" src="" alt=""> --}}
                
                    </div>
                </div>
            </div>
        </div>
    </div>

</accomplishment-listing>

@endsection