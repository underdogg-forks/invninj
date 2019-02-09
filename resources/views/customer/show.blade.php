@extends('layouts.master', ['header' => $header])

@section('body')
<main class="main" id="customer_show">

    <!-- Breadcrumb-->
    {{ Breadcrumbs::render('customers.show', $customer) }}

    <vue-toastr ref="toastr"></vue-toastr>

    <div class="container-fluid">


        <customer-show :customer="{{ $customer }}" :company="{{ $company }}" :meta="{{ $meta }}"></customer-show>


    </div>

</main>

<script defer src=" {{ mix('/js/customer_show.min.js') }}"></script>

@endsection
