<?php

namespace App\Factory;

use App\Models\Customer;

class CustomerFactory
{
	public static function create(int $company_id, int $user_id) :Customer
	{
		$customer = new Customer;
		$customer->company_id = $company_id;
		$customer->user_id = $user_id;
		$customer->name = '';
		$customer->website = '';
		$customer->private_notes = '';
		$customer->balance = 0;
		$customer->paid_to_date = 0;
		$customer->country_id = 4;
		$customer->is_deleted = 0;

		$customer_contact = CustomerContactFactory::create($company_id, $user_id);
        $customer->contacts->add($customer_contact);

		return $customer;
	}
}
