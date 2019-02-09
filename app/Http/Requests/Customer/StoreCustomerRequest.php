<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\Request;
use App\Models\Customer;

class StoreCustomerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize() : bool
    {
        return $this->user()->can('create', Customer::class);
    }

    public function rules()
    {
        /* Ensure we have a customer name, and that all emails are unique*/
        $rules['name'] = 'required';

        $contacts = request('contacts');

            for ($i = 0; $i < count($contacts); $i++) {
                $rules['contacts.' . $i . '.email'] = 'required|email|unique:customer_contacts,email,' . isset($contacts[$i]['id']);
            }

            return $rules;
            

    }

    public function messages()
    {
        return [
            'unique' => ctrans('validation.unique', ['attribute' => 'email']),
            //'required' => trans('validation.required', ['attribute' => 'email']),
            'contacts.*.email.required' => ctrans('validation.email', ['attribute' => 'email']),
        ];
    }


}