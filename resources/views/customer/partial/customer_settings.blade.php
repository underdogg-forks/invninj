<div class="col-lg-5">
    <div class="card">
        <div class="card-header bg-primary">@lang('texts.settings')</div>

        <div class="card-body">


            <fieldset class="form-group row">
                <label for="date" class="col-sm-3 col-form-label text-right">Currency</label>
                <div class="input-group col-sm-5">
                    <span class="input-group-prepend">
                    <span class="input-group-text">
                    <i class="fa fa-usd"></i>
                    </span>
                    </span>
                    <input class="form-control" id="date" type="text">
                </div>
                <small class="text-muted">ex. USD</small>
            </fieldset>


            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.currency')</label>
                <div class="col-sm-9">
                    {{ html()->input('name')->placeholder(__('texts.customer_name'))->value($customer->present()->name)->class('form-control')->id('name') }}
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.id_number')</label>
                <div class="col-sm-9">
                    {{ html()->input('id_number')->placeholder(__('texts.id_number'))->value($customer->id_number)->class('form-control')->id('id_number') }}
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.vat_number')</label>
                <div class="col-sm-9">
                    {{ html()->input('vat_number')->placeholder(__('texts.vat_number'))->value($customer->vat_number)->class('form-control')->id('vat_number') }}
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.website')</label>
                <div class="col-sm-9">
                    {{ html()->input('website')->placeholder(__('texts.website'))->value($customer->website)->class('form-control')->id('website') }}
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.custom_value1')</label>
                <div class="col-sm-9">
                    {{ html()->input('custom_value1')->placeholder(__('texts.custom_value1'))->value($customer->custom_value1)->class('form-control')->id('custom_value1') }}
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">@lang('texts.custom_value2')</label>
                <div class="col-sm-9">
                    {{ html()->input('custom_value2')->placeholder(__('texts.custom_value2'))->value($customer->custom_value2)->class('form-control')->id('custom_value2') }}
                </div>
            </div>
        </div>
    </div>
</div>