<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.school.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control"
            :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}"
            id="name" name="name" placeholder="{{ trans('admin.school.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.school.columns.address') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.address" v-validate="'required'" id="address"
                name="address"></textarea>
        </div>
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('letter_header'), 'has-success': fields.letter_header && fields.letter_header.valid }">
    <label for="letter_header" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.school.columns.letter_header') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.letter_header" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('letter_header'), 'form-control-success': fields.letter_header && fields.letter_header.valid}"
            id="letter_header" name="letter_header" placeholder="{{ trans('admin.school.columns.letter_header') }}">
        <div v-if="errors.has('letter_header')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('letter_header') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-3 text-right">
                <img src="{{url('public/images/logo.png')}}" style="height:5rem" alt="">
            </div>
            <div class="col-6 text-center">
                <p class="mb-0">Republic of the Philippines</p>
                <h6 class="mb-0 ">PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY</h6>
                <p class="mb-0">(Formerly Ramon Magsaysay Technological University)</p>
                <p>@{{form.letter_header}}</p>
            </div>
            <div class="col-3 text-left">
                <img src="{{url('public/images/gad.png')}}" style="height:7rem" alt="">
            </div>
        </div>

    </div>
</div>
<div class="form-check row"
    :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="status" type="checkbox" v-model="form.status" v-validate="''"
            data-vv-name="status" name="status_fake_element">
        <label class="form-check-label" for="status">
            {{ trans('admin.school.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}
        </div>
    </div>
</div>
