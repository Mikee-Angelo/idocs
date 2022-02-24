
<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('date_acquired'), 'has-success': fields.date_acquired && fields.date_acquired.valid }">
    <label for="date_acquired" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.liquidation-item.columns.date_acquired') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="date" v-model="form.date_acquired" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('date_acquired'), 'form-control-success': fields.date_acquired && fields.date_acquired.valid}"
            id="date_acquired" name="date_acquired"
            placeholder="{{ trans('admin.liquidation-item.columns.date_acquired') }}">
        <div v-if="errors.has('date_acquired')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('date_acquired') }}</div>
    </div>
</div>


<div class="form-group row align-items-center" :class="{'has-danger': errors.has('receipt_no'), 'has-success': fields.receipt_no && fields.receipt_no.valid }">
    <label for="receipt_no" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.liquidation-item.columns.receipt_no') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.receipt_no" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('receipt_no'), 'form-control-success': fields.receipt_no && fields.receipt_no.valid}" id="receipt_no" name="receipt_no" placeholder="{{ trans('admin.liquidation-item.columns.receipt_no') }}">
        <div v-if="errors.has('receipt_no')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('receipt_no') }}</div>
    </div>
</div>


<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('supplier'), 'has-success': fields.supplier && fields.supplier.valid }">
    <label for="supplier" class="col-form-label text-md-right"
        :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.liquidation-item.columns.supplier') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.supplier" v-validate="'required'" @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('supplier'), 'form-control-success': fields.supplier && fields.supplier.valid}"
            id="supplier" name="supplier" placeholder="{{ trans('admin.liquidation-item.columns.supplier') }}">
        <div v-if="errors.has('supplier')" class="form-control-feedback form-text" v-cloak>
            @{{ errors.first('supplier') }}</div>
    </div>
</div>

<h4 class="font-weight-bold">Items</h4>

<hr>

<div class="form-group row " v-for="(input,k) in form.inputs" :key="k">
    
    <div class="col-2">
        <div class="form-group align-items-center"
            :class="{'has-danger': errors.has('input.item'), 'has-success': input.item && input.item.valid }">
            <label for="input.item"
                class="col-form-label text-md-right">{{ trans('admin.liquidation-item.columns.item') }}</label>
            <input type="text" v-model="form.inputs[k].item" v-validate="'required'" @input="validate($event)"
                class="form-control"
                :class="{'form-control-danger': errors.has('input.item'), 'form-control-success': input.item && input.item.valid}"
                v-bind:id="'form.inputs[k].item'" :name="`form.inputs[k].item`" placeholder="{{ trans('admin.liquidation-item.columns.item') }}">
            <div v-if="errors.has('input.item')" class="form-control-feedback form-text" v-cloak>
                @{{ errors.first('input.item') }}</div>

        </div>
    </div>

    <div class="col-2">
        <div class="form-group align-items-center "
            :class="{'has-danger': errors.has('input.unit'), 'has-success': input.unit && input.unit.valid }">
            <label for="input.unit"
                class="col-form-label text-md-right">{{ trans('admin.liquidation-item.columns.unit') }}</label>
            <select class="form-control" v-model="form.inputs[k].unit" v-validate="'required'" @input="validate($event)"
                class="form-control"
                :class="{'form-control-danger': errors.has('input.unit'), 'form-control-success': input.unit && input.unit.valid}"
                v-bind:id="`form.inputs[k].unit`" :name="`form.inputs[k].unit`">
                <option v-for="types in {{ $unit }}" :value="types.id">@{{types.name}}</option>
            </select>
            <div v-if="errors.has('input.unit')" class="form-control-feedback form-text" v-cloak>
                @{{ errors.first('input.unit') }}</div>

        </div>
    </div>

    <div class="col-2">
        <div class="form-group  align-items-center"
            :class="{'has-danger': errors.has('input.qty'), 'has-success': input.qty && input.qty.valid }">
            <label for="input.qty"
                class="col-form-label text-md-right">{{ trans('admin.liquidation-item.columns.qty') }}</label>
            <input type="number" v-model="form.inputs[k].qty"  @input="validate($event)"
                class="form-control"
                :class="{'form-control-danger': errors.has('input.qty'), 'form-control-success': input.qty && input.qty.valid}"
                v-bind:id="`form.inputs[k].qty`" :name="`form.inputs[k].qty`" placeholder="{{ trans('admin.liquidation-item.columns.qty') }}">
            <div v-if="errors.has('input.qty')" class="form-control-feedback form-text" v-cloak>
                @{{ errors.first('input.qty') }}</div>

        </div>
    </div>


    <div class="col-2">
        <div class="form-group align-items-center"
            :class="{'has-danger': errors.has('input.price'), 'has-success': input.price && input.price.valid }">
            <label for="input.price"
                class="col-form-label text-md-right">{{ trans('admin.liquidation-item.columns.price') }}</label>

            <input type="number" v-model="form.inputs[k].price"  @input="validate($event)"
                class="form-control"
                :class="{'form-control-danger': errors.has('input.price'), 'form-control-success': input.price && input.price.valid}"
                v-bind:id="`form.inputs[k].price`" :name="`form.inputs[k].price`" placeholder="{{ trans('admin.liquidation-item.columns.price') }}">
            <div v-if="errors.has('input.price')" class="form-control-feedback form-text" v-cloak>
                @{{ errors.first('input.price') }}</div>

        </div>

    </div>

    
    <div class="col-2">
        <div class="form-group align-items-center">
            <label for="item.subtotal"
                class="col-form-label text-md-right">{{ trans('admin.liquidation-item.columns.subtotal') }}</label>

            <h4>₱ <span v-if="input.qty != null && input.price != null">@{{ (input.qty * input.price)}}</span></h4>
        </div>
    </div>

    <div class="col-2 my-auto">
        <span>
            <i class="fa fa-minus-circle text-danger" @click="remove(k)" v-show="k || ( !k && form.inputs.length > 1)"></i>  

            <i class="fa fa-plus-circle text-success" @click="add(k)" v-show="k == form.inputs.length-1"></i>
        </span>
    </div>
</div>

<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="application/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
