<?php

namespace App\Models;

use App\Utils\Traits\MakesHash;
use Hashids\Hashids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laracasts\Presenter\PresentableTrait;


class CustomerContact extends Authenticatable
{
    use Notifiable;
    use MakesHash;
    use PresentableTrait;
    use SoftDeletes;

   // protected $appends = ['contact_id'];

    protected $guard = 'contact';

    protected $presenter = 'App\Models\Presenters\CustomerContactPresenter';

    protected $dates = ['deleted_at'];
    
    protected $guarded = [
        'id',
    ];
   
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    
    public function getRouteKeyName()
    {
        return 'contact_id';
    }

    public function getContactIdAttribute()
    {
        return $this->encodePrimaryKey($this->id);
    }

    public function customer()
    {
        $this->hasOne(Customer::class);
    }

    public function primary_contact()
    {
        $this->where('is_primary', true);
    }

}
