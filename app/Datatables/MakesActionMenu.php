<?php

namespace App\Datatables;

use Illuminate\Support\Collection;

/**
 * Class MakesActionMenu
 * @package App\Datatables
 */
trait MakesActionMenu
{
    /**
     * Returns all possible datatable actions 
     * this list will be the single source of truth
     * for all Select Actions
     * 
     * @return Collection collection instance of action items
     */
	public function actions() :Collection
	{

    return collect([
		['action' => 'view_customer_customer_id', 'permission' => 'view_customer', 'route' => 'customers.show', 'key' => 'customer_id', 'name' => ctrans('texts.view')],
        ['action' => 'edit_customer_customer_id', 'permission' => 'edit_customer', 'route' => 'customers.edit', 'key' => 'customer_id', 'name' => ctrans('texts.edit')],
        ['action' => 'create_task_customer_id', 'permission' => 'create_task', 'route' => 'tasks.create', 'key' => 'customer_id', 'name' => ctrans('texts.new_task')],
        ['action' => 'create_invoice_customer_id', 'permission' => 'create_invoice', 'route' => 'invoices.create', 'key' => 'customer_id', 'name' => ctrans('texts.new_invoice')],
        ['action' => 'create_quote_customer_id', 'permission' => 'create_quote', 'route' => 'quotes.create', 'key' => 'customer_id', 'name' => ctrans('texts.new_quote')],
        ['action' => 'create_recurring_invoice_customer_id', 'permission' => 'create_recurring_invoice', 'route' => 'recurring_invoices.create', 'key' => 'customer_id', 'name' => ctrans('texts.new_recurring_invoice')],
        ['action' => 'enter_payment_customer_id', 'permission' => 'create_payment', 'route' => 'payments.create', 'key' => 'customer_id', 'name' => ctrans('texts.enter_payment')], 
        ['action' => 'enter_credit_customer_id', 'permission' => 'create_credit', 'route' => 'credits.create', 'key' => 'customer_id', 'name' => ctrans('texts.enter_credit')],
        ['action' => 'enter_expense_customer_id', 'permission' => 'create_expense', 'route' => 'expenses.create', 'key' => 'customer_id', 'name' => ctrans('texts.enter_expense')],

        ['action' => 'view_statement_customer_id', 'permission' => 'edit_customer', 'route' => 'customer_statement.show', 'key' => 'customer_id', 'name' => ctrans('texts.view_statement')],
    ]);


	}

    /**
     * To allow fine grained permissions we need to push the rows through a 
     * permissions/actions sieve.
     *
     * Complicating the calculation is the fact we allow a user who has 
     * create_entity permissions to also view/edit entities they have created.
     *
     * This must persist even if we later remove their create_entity permissions.
     *
     * The only clean way is to push each row through the sieve and push in view/edit permissions
     * onto the users permissions array on a per-row basis. 
     * 
     * @param  array $requested_actions - array of requested actions for menu
     * @param  stdClass $rows - requested $rows for datatable
     * @param  Class::class - need so we can harvest entity string
     * @return stdClass
     */
    public function processActionsForDatatable(array $requested_actions, $rows, $entity)
    {

        $rows->map(function ($row) use ($requested_actions, $entity){

            $row->actions = $this->createActionCollection($requested_actions, $row, $entity);

            return $row;

        });

        return $rows;

    }

    /**
     * Method which allows the generation of a collection of action links
     * for use when populating a Button.
     * 
     * @param  array $requested_actions - array of requested actions for menu
     * @param  Class::class - need so we can harvest entity string
     * @return stdClass
     */

    public function processActionsForButton(array $requested_actions, $entity)
    {
        $rows = $this->filterActions($requested_actions, auth()->user()->permissions(), auth()->user()->isAdmin());
        
        $updated_actions = $rows->map(function($row) use ($entity){

            $row['url'] = route($row['route'], [$row['key'] => $this->encodePrimaryKey($entity->id)]);

            return $row;
        });

        return $updated_actions;    

    }

    /**
     * Builds the actions for a single row of a datatable
     * 
     * @param  array $requested_actions - array of requested actions for menu
     * @param  stdClass $row - single $row for datatable
     * @param  Class::class - need so we can harvest entity string
     * @return Collection
     */
    private function createActionCollection($requested_actions, $row, $entity) : Collection
    {
        $permissions = auth()->user()->permissions();

        if(auth()->user()->owns($row))
            array_push($permissions, 'view_' . strtolower(class_basename($entity)), 'edit_' .strtolower(class_basename($entity))); 

        $updated_actions = $this->filterActions($requested_actions, $permissions, auth()->user()->isAdmin())->map(function ($action) use($row){

            $action['url'] = route($action['route'], [$action['key'] => $this->encodePrimaryKey($row->id)]);
            return $action;

        });

        return $updated_actions;   

    }

    /**
     * Filters the main actions collection down to the requested
     * actions for this menu
     * 
     * @param  array  $actions     Array of actions requested
     * @param  array  $permissions Array of user permissions
     * @param  bool   $isAdmin    Boolean isAdmin
     * @return Collection collection of filtered actions available to the user
     */
    public function filterActions(array $actions, array $permissions, bool $is_admin) :Collection
    {

    	return $this->checkPermissions($this->actions()->whereIn('action', $actions), $permissions, $is_admin);

    }

    /**
     * Checks the user permissions against the collection and returns
     * a Collection of available actions.
     * 
     * @param  Collection $actions  collection of possible actions
     * @param  bool       $isAdmin boolean defining if user is an administrator
     * @return Collection collection of filtered actions
     * 
     */
    private function checkPermissions(Collection $actions, array $permissions, bool $is_admin) :Collection
    {

        if($is_admin === TRUE)
            return $actions;

        return $actions->whereIn('permission', $permissions);
        
    }
}