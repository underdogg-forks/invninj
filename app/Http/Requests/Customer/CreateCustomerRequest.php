<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use App\Models\Customer;

class CreateCustomerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() : bool
    {
        return $this->user()->can('create', Customer::Class);
    }

}