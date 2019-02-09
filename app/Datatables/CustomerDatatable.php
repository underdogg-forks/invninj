<?php

namespace App\Datatables;

use App\Datatables\MakesActionMenu;
use App\Filters\CustomerFilters;
use App\Models\Customer;
use App\Utils\Traits\MakesHash;
use App\Utils\Traits\UserSessionAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class CustomerDatatable
 * @package App\Datatables
 */
class CustomerDatatable extends EntityDatatable
{
    use MakesHash;
    use MakesActionMenu;

    /**
     * @var CustomerFilters
     */
    protected $filter;

    /**
     * CustomerDatatable constructor.
     * @param CustomerFilters $filter
     */
    public function __construct(CustomerFilters $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Returns paginated results for the datatable
     *
     */
    public function query(Request $request, int $company_id)
    {
        $data = $this->filter->apply($company_id, auth()->user())->paginate($request->input('per_page'));

        return response()->json($this->buildActionColumn($data), 200);

    }

    /**
     * Returns the action dropdown menu 
     * 
     * @param   $rows   Std Class of customer datatable rows
     * @return  object  Rendered action column items
     */
    private function buildActionColumn($rows)
    {

      $requested_actions = [
          'view_customer_customer_id', 
          'edit_customer_customer_id', 
          'create_task_customer_id', 
          'create_invoice_customer_id', 
          'create_payment_customer_id', 
          'create_credit_customer_id', 
          'create_expense_customer_id'
      ];

      /*
       * Build a collection of action
       */
      $rows = $this->processActionsForDatatable($requested_actions, $rows, Customer::class);

      /*
       * Add a _view_ link directly to the customer
       */
      $rows->map(function($row){

        $row->name = '<a href="' . route('customers.show', ['id' => $this->encodePrimaryKey($row->id)]) . '">' . $row->name . '</a>';
        return $row;

      });

      return $rows;
        
    }

    /**
     * Returns a collection of helper fields
     * for the Customer List Datatable
     * 
     * @return Collection collection
     */
    public function listActions() : Collection
    {
      return collect([
        'multi_select' => [
            ['name' => ctrans('texts.active'), 'value' => 'active'],
            ['name' => ctrans('texts.archived'), 'value' => 'archived'],
            ['name' => ctrans('texts.deleted'), 'value' => 'deleted']
          ],
        'create_entity' => [
          'create_permission' => auth()->user()->can('create', Customer::class),
          'url' => route('customers.create'),
          'name' => ctrans('texts.new_customer')
        ]
      ]);
    }

    /**
     * Returns the Datatable settings including column visibility
     *     
     * @return Collection collection
     */
    public function buildOptions() : Collection
    {

      //$visible = auth()->user()->getColumnVisibility(Customer::class);
      $company = auth()->user()->company();

        return collect([
            'per_page' => 25,
            'sort_order' => [
                [
                  'field' => 'name',
                  'sortField' => 'name',
                  'direction' => 'asc',
                ]
            ],
            'fields' => [
                [
                  'name' => '__checkbox',   
                  'title' => '',
                  'titleClass' => 'center aligned',
                  'visible' => true,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'name',
                  'title' => ctrans('texts.name'),
                  'sortField' => 'name',
                  'visible' => true,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'contact',
                  'title' => ctrans('texts.contact'),
                  'sortField' => 'contact',
                  'visible' => true,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'email',
                  'title' => ctrans('texts.email'),
                  'sortField' => 'email',
                  'visible' => false,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'customer_created_at',
                  'title' => ctrans('texts.date_created'),
                  'sortField' => 'customer_created_at',
                  'visible' => false,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'last_login',
                  'title' => ctrans('texts.last_login'),
                  'sortField' => 'last_login',
                  'visible' => false,
                  'dataClass' => 'center aligned'
                ],
                [
                  'name' => 'balance',
                  'title' => ctrans('texts.balance'),
                  'sortField' => 'balance',
                  'visible' => false,
                  'dataClass' => 'center aligned'             
                ],
                [
                  'name' => 'custom_value1',
                  'title' => $company->custom_customer_label1 ?: '',
                  'sortField' => 'custom_value1',
                  'visible' => false,
                  'dataClass' => 'center aligned'             
                ],
                [
                  'name' => 'custom_value2',
                  'title' => $company->custom_customer_label2 ?: '',
                  'sortField' => 'custom_value2',
                  'visible' => false,
                  'dataClass' => 'center aligned'             
                ],
                                [
                  'name' => 'custom_value3',
                  'title' => $company->custom_customer_label3 ?: '',
                  'sortField' => 'custom_value3',
                  'visible' => false,
                  'dataClass' => 'center aligned'             
                ],
                                [
                  'name' => 'custom_value4',
                  'title' => $company->custom_customer_label4 ?: '',
                  'sortField' => 'custom_value4',
                  'visible' => false,
                  'dataClass' => 'center aligned'             
                ],
                [
                  'name' => '__component:customer-actions',   
                  'title' => '',
                  'titleClass' => 'center aligned',
                  'visible' => true,
                  'dataClass' => 'center aligned'
                ]
            ]
        ]);
    }

}