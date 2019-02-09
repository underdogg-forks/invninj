    @extends('layouts.master', ['header' => $header])

@section('body')
<main class="main" id="customer_create">

    <!-- Breadcrumb-->
    {{ Breadcrumbs::render('customers.create') }}

<form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
    <div class="container-fluid">
        
        <vue-toastr ref="toastr"></vue-toastr>

        <div class="row">
            <!-- Customer Details and Address Column -->
            <div class="col-md-6">
                				
				@include('customer.partial.customer_details', $customer)                               

                @include('customer.partial.customer_location')

            </div>
            <!-- End Customer Details and Address Column -->

            <!-- Contact Details Column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary2">{{ trans('texts.contact_information') }}
                        <span class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" @click="add()"><i class="fa fa-plus-circle"></i> {{ trans('texts.add_contact') }}</button>
                        </span>
                    </div>
                    
                    <template v-for="(contact, key, index) in form.contacts">
	                    @include('customer.partial.contact_details')
                    </template>
	            
                </div>    
            </div>     
            <!-- End Contact Details Column --> 
        </div> 

        <div class="row"> 
            <div class="col-md-12 text-center">
                <button class="btn btn-lg btn-success" type="button" @click="onSubmit"><i class="fa fa-save"></i> {{ trans('texts.save') }}</button>
            </div>
        </div>    

    </div>
</form>


</main>
<script>
    var customer_object = {!! $customer !!};
    var hashed_id = '';
</script>

<script defer src=" {{ mix('/js/customer_create.min.js') }}"></script>
@endsection