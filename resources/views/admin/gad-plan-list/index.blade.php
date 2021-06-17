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
                        @if(Auth::user()->roles()->pluck('id')[0] == 2)
                            @if(is_null($status))
                                 <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/gad-plan-lists/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.create') }}</a>
                            @elseif($status == 0)
                                <form @submit.prevent="submitStatus('submit-status', true)">
                                    <button type="submit" class="btn btn-success btn-spinner btn-sm pull-right m-b-0 text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-send"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.submit') }}</button>
                                </form>
                            @endif
                        @else
                            @if($status <= 1 || is_null($status))
                                <form @submit.prevent="changeStatus('change-status', true)">
                                    <button type="submit" class="btn btn-success btn-spinner btn-sm pull-right m-b-0 text-white ml-2" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-check"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.accept') }}</button>
                                </form>
                                <form @submit.prevent="changeStatus('change-status', false)">
                                    <button type="submit" class="btn btn-danger btn-spinner btn-sm pull-right m-b-0 text-white" title="{{ trans('brackets/admin-ui::admin.btn.accept') }}" role="button"><i class="fa fa-close"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.decline') }}</button>
                                </form>
                            @endif
                        @endif
                        <i class="fa fa-align-justify"></i> {{ trans('admin.gad-plan-list.actions.index') }}

                    </div>

                    <div class="card-body" v-cloak>
                        <div class="card-block">

                            
                            @if(Auth::user()->roles()->pluck('id')[0] == 2)
                                <form @submit.prevent="">
                                    <div class="row justify-content-md-between">
                                        <div class="col col-lg-7 col-xl-5 form-group">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto form-group ">
                                            <select class="form-control" v-model="pagination.state.per_page">
                                                
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>

                                        
                                        @if(Auth::user()->roles()->pluck('id')[0] == 2)
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                    #
                                                </label>
                                            </th>
                                        @endif

                                        <th is='sortable' :column="'id'">{{ trans('admin.gad-plan-list.columns.id') }}</th>
                                        <th is='sortable' :column="'gad_issue_mandate'">{{ trans('admin.gad-plan-list.columns.gad_issue_mandate') }}</th>
                                        <th is='sortable' :column="'cause_of_issue'">{{ trans('admin.gad-plan-list.columns.cause_of_issue') }}</th>
                                        <th is='sortable' :column="'gad_statement_objective'">{{ trans('admin.gad-plan-list.columns.gad_statement_objective') }}</th>
                                        <th is='sortable' :column="'relevant_agencies'">{{ trans('admin.gad-plan-list.columns.relevant_agencies') }}</th>
                                        <th is='sortable' :column="'gad_activity'">{{ trans('admin.gad-plan-list.columns.gad_activity') }}</th>
                                        <th is='sortable' :column="'indicator_target'">{{ trans('admin.gad-plan-list.columns.indicator_target') }}</th>
                                        <th is='sortable' :column="'budget_requirement'">{{ trans('admin.gad-plan-list.columns.budget_requirement') }}</th>
                                        <th is='sortable' :column="'budget_source'">{{ trans('admin.gad-plan-list.columns.budget_source') }}</th>
                                        <th is='sortable' :column="'responsible_unit'">{{ trans('admin.gad-plan-list.columns.responsible_unit') }}</th>

                                        <th></th>
                                    </tr>

                                    @if(Auth::user()->roles()->pluck('id')[0] == 2 && is_null($status))
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/gad-plan-lists')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                            href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/gad-plan-lists/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                                </span>

                                            </td>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        
                                        @if(Auth::user()->roles()->pluck('id')[0] == 2)
                                            <td class="bulk-checkbox">
                                                <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                                <label class="form-check-label" :for="'enabled' + item.id">
                                                </label>
                                            </td>
                                        @endif

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.gad_issue_mandate }}</td>
                                        <td>@{{ item.cause_of_issue }}</td>
                                        <td>@{{ item.gad_statement_objective }}</td>
                                        <td>@{{ item.relevant_agency.name }}</td>
                                        <td>@{{ item.gad_activity }}</td>
                                        <td>@{{ item.indicator_target }}</td>
                                        <td>@{{ item.budget_requirement }}</td>
                                        <td>@{{ item.sourceofbudget.name }}</td>
                                        <td>@{{ item.responsible_unit }}</td>
                                        

                                        @if(Auth::user()->roles()->pluck('id')[0] == 2 && is_null($status))
                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                            </td>

                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            
                            @if(Auth::user()->roles()->pluck('id')[0] == 2)
                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>
                            @endif
                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                
                                @if(Auth::user()->roles()->pluck('id')[0] == 2)
                                    <a class="btn btn-primary btn-spinner" href="{{ url('admin/gad-plan-lists/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.gad-plan-list.actions.create') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </gad-plan-list-listing>

@endsection