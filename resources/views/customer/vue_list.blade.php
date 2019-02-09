@extends('layouts.master', ['header' => $header])

@section('head')

@endsection

@section('body')
    @parent
    <main class="main" >
        <!-- Breadcrumb-->
        {{ Breadcrumbs::render('customers') }}

        <div class="container-fluid" id="customer_list">
            <vue-toastr ref="toastr"></vue-toastr>
            
            <list-actions :listaction="{{ $listaction }}" :per_page_prop="{{ $datatable['per_page'] }}"></list-actions>

            <div style="background: #fff;">
                
                <customer-list :datatable="{{ $datatable }}"></customer-list>
                
            </div>

        </div>

    </main>

    <script defer src=" {{ mix('/js/customer_list.min.js') }}"></script>

@endsection

@section('footer')
    
@endsection