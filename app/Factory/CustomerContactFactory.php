<?php

namespace App\Factory;

use App\Models\CustomerContact;

class CustomerContactFactory
{
	public static function create(int $company_id, int $user_id) :CustomerContact
	{
		$customer_contact = new CustomerContact;
        $customer_contact->first_name = "";
        $customer_contact->user_id = $user_id;
        $customer_contact->company_id = $company_id;
        $customer_contact->id = 0;

		return $customer_contact;
	}
}
