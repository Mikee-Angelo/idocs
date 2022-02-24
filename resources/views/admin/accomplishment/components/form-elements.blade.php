<div  class="form-group row align-items-center" :class="{'has-danger': errors.has('header'), 'has-success': fields.header && fields.header.valid }">
    <label for="header" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.accomplishment.columns.header') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" autocomplete="off" v-model="form.header" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('header'), 'form-control-success': fields.header && fields.header.valid}" id="header" name="header" placeholder="{{ trans('admin.accomplishment.columns.header') }}">
        <div v-if="errors.has('header')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('header') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.accomplishment.columns.description') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" v-validate="'required'" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>


@include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => app(App\Models\Accomplishment::class)->getMediaCollection('gallery'),
    'label' => 'Gallery'
])
