<div class="form-group row align-items-center" :class="{'has-danger': errors.has('role_id'), 'has-success': fields.role_id && fields.role_id.valid }">
    <label for="role_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan.columns.role_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.role_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('role_id'), 'form-control-success': fields.role_id && fields.role_id.valid}" id="role_id" name="role_id" placeholder="{{ trans('admin.gad-plan.columns.role_id') }}">
        <div v-if="errors.has('role_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('role_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('model_type'), 'has-success': fields.model_type && fields.model_type.valid }">
    <label for="model_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan.columns.model_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.model_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('model_type'), 'form-control-success': fields.model_type && fields.model_type.valid}" id="model_type" name="model_type" placeholder="{{ trans('admin.gad-plan.columns.model_type') }}">
        <div v-if="errors.has('model_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('model_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('model_id'), 'has-success': fields.model_id && fields.model_id.valid }">
    <label for="model_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.gad-plan.columns.model_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.model_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('model_id'), 'form-control-success': fields.model_id && fields.model_id.valid}" id="model_id" name="model_id" placeholder="{{ trans('admin.gad-plan.columns.model_id') }}">
        <div v-if="errors.has('model_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('model_id') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="status" type="checkbox" v-model="form.status" v-validate="''" data-vv-name="status"  name="status_fake_element">
        <label class="form-check-label" for="status">
            {{ trans('admin.gad-plan.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>

