<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerContact;

/**
 * 
 */
class CustomerContactRepository extends BaseRepository
{

	public function save(array $contacts, Customer $customer) : void
	{

		/* Convert array to collection */
		$contacts = collect($contacts);

		/* Get array of IDs which have been removed from the contacts array and soft delete each contact */
		collect($customer->contacts->pluck('id'))->diff($contacts->pluck('id'))->each(function($contact){
			CustomerContact::destroy($contact);
		});

		/* Set first record to primary - always*/
		$contacts = $contacts->sortBy('is_primary');

		$contacts->first(function($contact){
			$contact['is_primary'] = true;
		});

		//loop and update/create contacts
		$contacts->each(function ($contact) use ($customer){ 

			$update_contact = CustomerContact::firstOrNew(
				['id' => $contact['id']],
				[
					'customer_id' => $customer->id, 
					'company_id' => $customer->company_id,
					'user_id' => auth()->user()->id
				]
			);

			$update_contact->fill($contact);
			$update_contact->save();
		});


	}
	



}