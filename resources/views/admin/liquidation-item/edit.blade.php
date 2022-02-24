@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.liquidation-item.actions.edit', ['name' => $liquidationItem->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <liquidation-item-form
                :action="'{{ $liquidationItem->resource_url }}'"
                :data="{{ $liquidationItem->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.liquidation-item.actions.edit', ['name' => $liquidationItem->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.liquidation-item.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </liquidation-item-form>

        </div>
    
</div>

@endsection