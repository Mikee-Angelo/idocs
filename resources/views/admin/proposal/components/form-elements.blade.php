<div class="form-group row align-items-center" :class="{'has-danger': errors.has('letter_body'), 'has-success': fields.letter_body && fields.letter_body.valid }">
    <label for="letter_body" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.proposal.columns.letter_body') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
             <wysiwyg  class="form-control" v-model="form.letter_body" v-validate="'required'" id="letter_body" name="letter_body":config="mediaWysiwygConfig" />
        </div>
        <div v-if="errors.has('letter_body')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('letter_body') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('proposal_body'), 'has-success': fields.proposal_body && fields.proposal_body.valid }">
    <label for="proposal_body" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.proposal.columns.proposal_body') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg class="form-control" v-model="form.proposal_body" v-validate="'required'" id="proposal_body" name="proposal_body" :config="mediaWysiwygConfig" />
        </div>
        <div v-if="errors.has('proposal_body')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('proposal_body') }}</div>
    </div>
</div>


