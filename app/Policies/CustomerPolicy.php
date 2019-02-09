<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

/**
 * Class CustomerPolicy
 * @package App\Policies
 */
class CustomerPolicy extends EntityPolicy
{
	/**
	 *  Checks if the user has create permissions
	 *  
	 * @param  User $user
	 * @return bool
	 */
	public function create(User $user) : bool
	{
		return $user->isAdmin() || $user->hasPermission('create_customer');
	}

}
