<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('letter_body'), 'has-success': fields.letter_body && fields.letter_body.valid }">
    <label for="letter_body" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.reimbursement.columns.letter_body') }}</label>

    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="row">
            <div class="col-3 text-right">
                <img src="{{url('public/images/logo.png')}}" style="height:5rem" alt="">
            </div>
            <div class="col-6 text-center">
                <p class="mb-0">Republic of the Philippines</p>
                <h6 class="mb-0 ">PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY</h6>
                <p class="mb-0">(Formerly Ramon Magsaysay Technological University)</p>
                <p>{{Auth::user()->user_school->letter_header}}</p>
            </div>
            <div class="col-3 text-left">
                <img src="{{url('public/images/gad.png')}}" style="height:7rem" alt="">
            </div>
        </div>
        <hr class="mt-0" style="border:solid thin black">
        <h5 class="text-center font-weight-bold mb-5">Office of Gender and Development</h5>

        <div>
            <wysiwyg class="form-control" v-model="form.letter_body" v-validate="'required'" id="letter_body"
                name="letter_body" />
        </div>
        <div v-if="errors.has('letter_body')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('letter_body') }}</div>
    </div>
</div>
