<?php

namespace Modules\Notes\Entities;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	/*
    protected $guarded = [
    		'id',
    ];
*/
    protected $fillable = ["description"];


    protected $table = 'notes';

    public function customer()
    {
        return $this->hasOne(App\Models\Customer::class);
    }

    public function notes()
    {
    	return $this->hasMany(Note::class);
    }

}
