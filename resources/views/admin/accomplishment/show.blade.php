@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.reimbursement.actions.index'))

@section('body')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
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
@endsection