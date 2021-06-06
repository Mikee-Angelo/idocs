
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gad_issue_mandate'), 'has-success': fields.gad_issue_mandate && fields.gad_issue_mandate.valid }">
    <label for="gad_issue_mandate" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.gad_issue_mandate') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.gad_issue_mandate" v-validate="'required'" id="gad_issue_mandate" name="gad_issue_mandate"></textarea>
        </div>
        <div v-if="errors.has('gad_issue_mandate')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gad_issue_mandate') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('cause_of_issue'), 'has-success': fields.cause_of_issue && fields.cause_of_issue.valid }">
    <label for="cause_of_issue" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.cause_of_issue') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.cause_of_issue" v-validate="'required'" id="cause_of_issue" name="cause_of_issue"></textarea>
        </div>
        <div v-if="errors.has('cause_of_issue')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('cause_of_issue') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gad_statement_objective'), 'has-success': fields.gad_statement_objective && fields.gad_statement_objective.valid }">
    <label for="gad_statement_objective" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.gad_statement_objective') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.gad_statement_objective" v-validate="'required'" id="gad_statement_objective" name="gad_statement_objective"></textarea>
        </div>
        <div v-if="errors.has('gad_statement_objective')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gad_statement_objective') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('relevant_agencies'), 'has-success': fields.relevant_agencies && fields.relevant_agencies.valid }">
    <label for="relevant_agencies" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.relevant_agencies') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.relevant_agencies" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('relevant_agencies'), 'form-control-success': fields.relevant_agencies && fields.relevant_agencies.valid}" id="relevant_agencies" name="relevant_agencies" placeholder="{{ trans('admin.gad-plan-list.columns.relevant_agencies') }}">
        <div v-if="errors.has('relevant_agencies')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('relevant_agencies') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gad_activity'), 'has-success': fields.gad_activity && fields.gad_activity.valid }">
    <label for="gad_activity" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.gad_activity') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.gad_activity" v-validate="'required'" id="gad_activity" name="gad_activity"></textarea>
        </div>
        <div v-if="errors.has('gad_activity')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gad_activity') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('indicator_target'), 'has-success': fields.indicator_target && fields.indicator_target.valid }">
    <label for="indicator_target" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.indicator_target') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.indicator_target" v-validate="'required'" id="indicator_target" name="indicator_target"></textarea>
        </div>
        <div v-if="errors.has('indicator_target')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('indicator_target') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('budget_requirement'), 'has-success': fields.budget_requirement && fields.budget_requirement.valid }">
    <label for="budget_requirement" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.budget_requirement') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.budget_requirement" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('budget_requirement'), 'form-control-success': fields.budget_requirement && fields.budget_requirement.valid}" id="budget_requirement" name="budget_requirement" placeholder="{{ trans('admin.gad-plan-list.columns.budget_requirement') }}">
        <div v-if="errors.has('budget_requirement')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('budget_requirement') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('budget_source'), 'has-success': fields.budget_source && fields.budget_source.valid }">
    <label for="budget_source" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.budget_source') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.budget_source" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('budget_source'), 'form-control-success': fields.budget_source && fields.budget_source.valid}" id="budget_source" name="budget_source" placeholder="{{ trans('admin.gad-plan-list.columns.budget_source') }}">
        <div v-if="errors.has('budget_source')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('budget_source') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('responsible_unit'), 'has-success': fields.responsible_unit && fields.responsible_unit.valid }">
    <label for="responsible_unit" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan-list.columns.responsible_unit') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.responsible_unit" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('responsible_unit'), 'form-control-success': fields.responsible_unit && fields.responsible_unit.valid}" id="responsible_unit" name="responsible_unit" placeholder="{{ trans('admin.gad-plan-list.columns.responsible_unit') }}">
        <div v-if="errors.has('responsible_unit')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('responsible_unit') }}</div>
    </div>
</div>


