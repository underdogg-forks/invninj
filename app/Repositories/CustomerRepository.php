<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\CustomerContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 
 */
class CustomerRepository extends BaseRepository
{

    public function getClassName()
    {
        return Customer::class;
    }
    
	public function save(Request $request, Customer $customer) : ?Customer
	{
        $customer->fill($request->input());
        $customer->save();

        return $customer;
	}

}