@extends('layouts.master', ['header' => $header])

@section('body')
<main class="main">
    <!-- Breadcrumb-->
    {{ Breadcrumbs::render('dashboard') }}
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12">
                <div class="col-lg-6">test</div>
                <div class="col-lg-6">test2</div>
            </div>
        </div>

    </div>
</main>
@endsection
