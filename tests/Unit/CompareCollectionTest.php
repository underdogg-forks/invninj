<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * @test
 * @covers  App\Utils\NumberHelper
 */
class CompareCollectionTest extends TestCase
{

    public function setUp()
    {
    
    parent::setUp();

    $this->map = collect([
        ['action' => 'view_customer_customer_id', 'permission' => 'view_customer', 'route' => 'customers.show', 'key' => 'customer_id', 'name' => trans('texts.view')],
        ['action' => 'edit_customer_customer_id', 'permission' => 'edit_customer', 'route' => 'customers.edit', 'key' => 'customer_id', 'name' => trans('texts.edit')],
        ['action' => 'create_task_customer_id', 'permission' => 'create_task', 'route' => 'task.create', 'key' => 'customer_id', 'name' => trans('texts.new_task')],
        ['action' => 'create_invoice_customer_id', 'permission' => 'create_invoice', 'route' => 'invoice.create', 'key' => 'customer_id', 'name' => trans('texts.new_invoice')],
        ['action' => 'enter_payment_customer_id', 'permission' => 'create_payment', 'route' => 'payment.create', 'key' => 'customer_id', 'name' => trans('texts.enter_payment')], 
        ['action' => 'enter_credit_customer_id', 'permission' => 'create_credit', 'route' => 'credit.create', 'key' => 'customer_id', 'name' => trans('texts.enter_credit')],
        ['action' => 'enter_expense_customer_id', 'permission' => 'create_expense', 'route' => 'expense.create', 'key' => 'customer_id', 'name' => trans('texts.enter_expense')]
    ]);

        $this->view_permission = ['view_customer'];

        $this->edit_permission = ['view_customer', 'edit_customer'];

        $this->is_admin = true;

        $this->is_not_admin = false;

    }

    public function testCompareResultOfComparison()
    {

        $this->assertEquals(7, $this->map->count()); 

    }

    public function testViewPermission()
    {

        $this->assertEquals(1, $this->checkPermissions($this->view_permission, $this->is_not_admin)->count());

    }

    public function testViewAndEditPermission()
    {

        $this->assertEquals(2, $this->checkPermissions($this->edit_permission, $this->is_not_admin)->count());

    }

    public function testAdminPermissions()
    {

        $this->assertEquals(7, $this->checkPermissions($this->view_permission, $this->is_admin)->count());

    }

    public function testActionViewCustomerFilter()
    {
        $actions = [
            'view_customer_customer_id'
        ];

        $this->assertEquals(1, $this->map->whereIn('action', $actions)->count());
    }

    public function testNoActionCustomerFilter()
    {
        $actions = [
            ''
        ];

        $this->assertEquals(0, $this->map->whereIn('action', $actions)->count());
    }

    public function testActionsAndPermissionsFilter()
    {
        $actions = [
            'view_customer_customer_id'

        ];

        $this->filterActions($actions);

        $this->assertEquals(1, $this->checkPermissions($this->view_permission, $this->is_not_admin)->count());

    }

    public function testActionAndPermissionsFilterFailure()
    {
        $actions = [
            'edit_customer_customer_id'

        ];

        $data = $this->filterActions($actions);

        $this->assertEquals(0, $data->whereIn('permission', $this->view_permission)->count());

    }

    public function testEditActionAndPermissionsFilter()
    {
        $actions = [
            'edit_customer_customer_id'

        ];

        $data = $this->filterActions($actions);
        $this->assertEquals(1, $data->whereIn('permission', $this->edit_permission)->count());
        
    }

    public function checkPermissions($permission, $is_admin)
    {

        if($is_admin === TRUE)
            return $this->map;

        return $this->map->whereIn('permission', $permission);
        
    }

    public function filterActions($actions)
    {
        return $this->map->whereIn('action', $actions);
    }

}
