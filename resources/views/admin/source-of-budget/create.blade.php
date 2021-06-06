@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.source-of-budget.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <source-of-budget-form
            :action="'{{ url('admin/source-of-budgets') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.source-of-budget.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.source-of-budget.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </source-of-budget-form>

        </div>

        </div>

    
@endsection