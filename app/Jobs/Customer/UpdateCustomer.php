<?php

namespace App\Jobs\Customer;


use App\Models\Customer;
use App\Repositories\CustomerContactRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateCustomer
{
    use Dispatchable;

    protected $request;

    protected $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(Request $request, Customer $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CustomerRepository $customerRepo, CustomerContactRepository $customerContactRepo) :?Customer
    {
        $customer = $customerRepo->save($this->request, $this->customer);
        
        $contacts = $customerContactRepo->save($this->request->input('contacts'), $customer);
        
        return $customer->fresh();
    }
}
