@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.supplier.actions.edit', ['name' => $supplier->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <supplier-form
                :action="'{{ $supplier->resource_url }}'"
                :data="{{ $supplier->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.supplier.actions.edit', ['name' => $supplier->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.supplier.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </supplier-form>

        </div>
    
</div>

@endsection