@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.gad-plan-list.actions.edit', ['name' => $gadPlanList->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <gad-plan-list-form
                :action="'{{ $gadPlanList->resource_url }}'"
                :data="{{ $gadPlanList->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.gad-plan-list.actions.edit', ['name' => $gadPlanList->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.gad-plan-list.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </gad-plan-list-form>

        </div>
    
</div>

@endsection