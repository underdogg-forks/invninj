<?php

namespace App\Filters;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/**
 * CustomerFilters
 */
class CustomerFilters extends QueryFilters
{

    /**
     * Filter by balance
     *     
     * @param  string $balance 
     * @return Illuminate\Database\Query\Builder 
     */
    public function balance(string $balance): Builder
    {
        $parts = $this->split($balance);

        return $this->builder->where('balance', $parts->operator, $parts->value);
    }

    /**
     * Filter between balances
     * 
     * @param  string balance
     * @return Illuminate\Database\Query\Builder
     */
    public function between_balance(string $balance): Builder
    {
        $parts = explode(":", $balance);

        return $this->builder->whereBetween('balance', [$parts[0], $parts[1]]);
    }

    /**
     * Filter based on search text
     * 
     * @param  string query filter
     * @return Illuminate\Database\Query\Builder
     */
    public function filter(string $filter = '') : Builder
    {
        if(strlen($filter) == 0)
            return $this->builder;

        return  $this->builder->where(function ($query) use ($filter) {
                    $query->where('customers.name', 'like', '%'.$filter.'%')
                          ->orWhere('customers.id_number', 'like', '%'.$filter.'%')
                          ->orWhere('customer_contacts.first_name', 'like', '%'.$filter.'%')
                          ->orWhere('customer_contacts.last_name', 'like', '%'.$filter.'%')
                          ->orWhere('customer_contacts.email', 'like', '%'.$filter.'%')
                          ->orWhere('customers.custom_value1', 'like' , '%'.$filter.'%')
                          ->orWhere('customers.custom_value2', 'like' , '%'.$filter.'%')
                          ->orWhere('customers.custom_value3', 'like' , '%'.$filter.'%')
                          ->orWhere('customers.custom_value4', 'like' , '%'.$filter.'%');
                });
    }

    /**
     * Filters the list based on the status
     * archived, active, deleted
     * 
     * @param  string filter
     * @return Illuminate\Database\Query\Builder
     */
    public function status(string $filter = '') : Builder
    {
        if(strlen($filter) == 0)
            return $this->builder;

        $table = 'customers';
        $filters = explode(',', $filter);

        return $this->builder->where(function ($query) use ($filters, $table) {
            $query->whereNull($table . '.id');

            if (in_array(parent::STATUS_ACTIVE, $filters)) {
                $query->orWhereNull($table . '.deleted_at');
            }

            if (in_array(parent::STATUS_ARCHIVED, $filters)) {
                $query->orWhere(function ($query) use ($table) {
                    $query->whereNotNull($table . '.deleted_at');

                    if (! in_array($table, ['users'])) {
                        $query->where($table . '.is_deleted', '=', 0);
                    }
                });
            }

            if (in_array(parent::STATUS_DELETED, $filters)) {
                $query->orWhere($table . '.is_deleted', '=', 1);
            }
        });
    }

    /**
     * Sorts the list based on $sort
     * 
     * @param  string sort formatted as column|asc
     * @return Illuminate\Database\Query\Builder
     */
    public function sort(string $sort) : Builder
    {
        $sort_col = explode("|", $sort);
        return $this->builder->orderBy($sort_col[0], $sort_col[1]);
    }

    /**
     * Returns the base query
     * 
     * @param  int company_id
     * @return Illuminate\Database\Query\Builder
     */
    public function baseQuery(int $company_id, User $user) : Builder
    {
        $query = DB::table('customers')
            ->join('companies', 'companies.id', '=', 'customers.company_id')
            ->join('customer_contacts', 'customer_contacts.customer_id', '=', 'customers.id')
            ->where('customers.company_id', '=', $company_id)
            ->where('customer_contacts.is_primary', '=', true)
            ->where('customer_contacts.deleted_at', '=', null)
            //->whereRaw('(customers.name != "" or contacts.first_name != "" or contacts.last_name != "" or contacts.email != "")') // filter out buy now invoices
            ->select(
                DB::raw('COALESCE(customers.currency_id, companies.currency_id) currency_id'),
                DB::raw('COALESCE(customers.country_id, companies.country_id) country_id'),
                DB::raw("CONCAT(COALESCE(customer_contacts.first_name, ''), ' ', COALESCE(customer_contacts.last_name, '')) contact"),
                'customers.id',
                'customers.name',
                'customers.private_notes',
                'customer_contacts.first_name',
                'customer_contacts.last_name',
                'customers.custom_value1',
                'customers.custom_value2',
                'customers.custom_value3',
                'customers.custom_value4',
                'customers.balance',
                'customers.last_login',
                'customers.created_at',
                'customers.created_at as customer_created_at',
                'customer_contacts.phone',
                'customer_contacts.email',
                'customers.deleted_at',
                'customers.is_deleted',
                'customers.user_id',
                'customers.id_number'
            );

        /**
         * If the user does not have permissions to view all invoices
         * limit the user to only the invoices they have created
         */
        if (Gate::denies('view-list', Customer::class)) {
            $query->where('customers.user_id', '=', $user->id);
        }


        return $query;
    }

}