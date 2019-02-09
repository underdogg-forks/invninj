<?php

namespace App\Http\Controllers;

use App\Datatables\CustomerDatatable;
use App\Datatables\MakesActionMenu;
use App\Factory\CustomerFactory;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\EditCustomerRequest;
use App\Http\Requests\Customer\ShowCustomerRequest;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Jobs\Customer\StoreCustomer;
use App\Jobs\Customer\UpdateCustomer;
use App\Jobs\Entity\ActionEntity;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\Country;
use App\Repositories\CustomerRepository;
use App\Utils\Traits\MakesHash;
use App\Utils\Traits\MakesMenu;
use App\Utils\Traits\UserSessionAttributes;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{
    use UserSessionAttributes;
    use MakesHash;
    use MakesMenu;
    use MakesActionMenu;

    /**
     * @var CustomerRepository
     */
    protected $customerRepo;

    /**
     * @var CustomerDatatable
     */
    protected $customerDatatable;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $customerRepo
     * @param CustomerDatatable $customerDatatable
     */
    public function __construct(CustomerRepository $customerRepo, CustomerDatatable $customerDatatable)
    {

        $this->customerRepo = $customerRepo;

        $this->customerDatatable = $customerDatatable;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
;
        if(request('page'))
            return $this->customerDatatable->query(request(), $this->getCurrentCompanyId());

        $data = [
            'datatable' => $this->customerDatatable->buildOptions(),
            'listaction' => $this->customerDatatable->listActions()
        ];

        return view('customer.list', $data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowCustomerRequest $request, Customer $customer)
    {

        $requested_view_statement_actions = [
            'create_invoice_customer_id', 
            'create_task_customer_id', 
            'create_quote_customer_id', 
            'create_recurring_invoice_customer_id', 
            'create_payment_customer_id', 
            'create_expense_customer_id'
        ];

       $data = [
            'customer' => $customer,
            'company' => auth()->user()->company(),
            'meta' => collect([
                'google_maps_api_key' => config('ninja.google_maps_api_key'),
                'edit_customer_permission' => auth()->user()->can('edit', $customer),
                'edit_customer_route' => $this->processActionsForButton(['edit_customer_customer_id'], $customer),
                'view_statement_permission' => auth()->user()->can('view', $customer),
                'view_statement_route' => $this->processActionsForButton(['view_statement_customer_id'], $customer),
                'view_statement_actions' => $this->processActionsForButton($requested_view_statement_actions, $customer)
            ])
        ];

        return view('customer.show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditCustomerRequest $request, Customer $customer)
    {

        $data = [
        'customer' => $customer,
        'settings' => $customer,
        'pills' => $this->makeEntityTabMenu(Customer::class),
        'hashed_id' => $this->encodePrimarykey($customer->id),
        'countries' => Country::all(),
        'company' => auth()->user()->company()
        ];

        return view('customer.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {

        $customer = UpdateCustomer::dispatchNow($request, $customer);

        return response()->json($customer, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateCustomerRequest $request)
    {
        $customer = CustomerFactory::create($this->getCurrentCompanyId(), auth()->user()->id);

        $data = [
            'customer' => $customer,
            'hashed_id' => '',
            'countries' => Country::all()
        ];

        return view('customer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {

        $customer = StoreCustomer::dispatchNow($request, new Customer);

        $customer->load('contacts', 'primary_contact');

        $customer->hashed_id = $this->encodePrimarykey($customer->id);

        return response()->json($customer, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Perform bulk actions on the list view
     * 
     * @return Collection
     */
    public function bulk()
    {

        $action = request()->input('action');
        
        $ids = request()->input('ids');

        $customers = Customer::withTrashed()->find($ids);

        $customers->each(function ($customer, $key) use($action){

            if(auth()->user()->can('edit', $customer))
                ActionEntity::dispatchNow($customer, $action);

        });

        //todo need to return the updated dataset
        return response()->json('success', 200);
        
    }

    /**
     * Returns a customer statement
     * 
     * @return [type] [description]
     */
    public function statement()
    {
        //todo
    }



}
