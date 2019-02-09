<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
       // return ! auth()->user(); //todo permissions
    }

    public function rules()
    {
        /* Ensure we have a customer name, and that all emails are unique*/
        $rules['name'] = 'required';

        $contacts = request('contacts');

            for ($i = 0; $i < count($contacts); $i++) {
                $rules['contacts.' . $i . '.email'] = 'required|email|unique:customer_contacts,email,' . $contacts[$i]['id'];
            }

            return $rules;
            

    }

    public function messages()
    {
        return [
            'unique' => ctrans('validation.unique', ['attribute' => 'email']),
            'email' => ctrans('validation.email', ['attribute' => 'email']),
            'name.required' => ctrans('validation.required', ['attribute' => 'name']),
            'required' => ctrans('validation.required', ['attribute' => 'email']),
        ];
    }


}