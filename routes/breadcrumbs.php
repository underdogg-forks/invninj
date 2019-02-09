<?php

// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(trans('texts.dashboard'), route('dashboard.index'));
});

// Dashboard > Customer
Breadcrumbs::for('customers', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('texts.customers'), route('customers.index'));
});

Breadcrumbs::for('customers.show', function($trail, $customer) {
    $trail->parent('customers');
    $trail->push($customer->name, route('customers.show', $customer));
});

Breadcrumbs::for('customers.edit', function($trail, $customer) {
    $trail->parent('customers');
    $trail->push($customer->name, route('customers.edit', $customer));
});

Breadcrumbs::for('customers.create', function($trail) {
    $trail->parent('customers');
});

