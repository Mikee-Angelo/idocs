<div class="form-group row align-items-center" :class="{'has-danger': errors.has('purpose'), 'has-success': fields.purpose && fields.purpose.valid }">
    <label for="purpose" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.liquidation.columns.purpose') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.purpose" v-validate="'required'" id="purpose" name="purpose"></textarea>
        </div>
        <div v-if="errors.has('purpose')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('purpose') }}</div>
    </div>
</div>
