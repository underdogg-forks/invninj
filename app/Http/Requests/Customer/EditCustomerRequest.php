<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use App\Models\Customer;

class EditCustomerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return $this->user()->can('edit', $this->customer);
        //return true;
       // return ! auth()->user(); //todo permissions
    }

    public function sanitize()
    {
        $input = $this->all();

        //$input['id'] = $this->encodePrimaryKey($input['id']);

        //$this->replace($input);

        return $this->all();
    }

}