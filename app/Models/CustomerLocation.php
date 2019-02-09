<?php

namespace App\Models;

use App\Utils\Traits\MakesHash;
use Illuminate\Database\Eloquent\Model;

class CustomerLocation extends BaseModel
{
    use MakesHash;

    public $timestamps = false;

    protected $appends = ['customer_location_id'];

    public function getRouteKeyName()
    {
        return 'customer_location_id';
    }

    public function getCustomerLocationIdAttribute()
    {
        return $this->encodePrimaryKey($this->id);
    }

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
