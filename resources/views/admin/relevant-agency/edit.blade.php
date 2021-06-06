@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.relevant-agency.actions.edit', ['name' => $relevantAgency->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <relevant-agency-form
                :action="'{{ $relevantAgency->resource_url }}'"
                :data="{{ $relevantAgency->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.relevant-agency.actions.edit', ['name' => $relevantAgency->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.relevant-agency.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </relevant-agency-form>

        </div>
    
</div>

@endsection