@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.event-type.actions.edit', ['name' => $eventType->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <event-type-form
                :action="'{{ $eventType->resource_url }}'"
                :data="{{ $eventType->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.event-type.actions.edit', ['name' => $eventType->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.event-type.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </event-type-form>

        </div>
    
</div>

@endsection