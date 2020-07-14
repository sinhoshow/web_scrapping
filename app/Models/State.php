<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class State extends Model
{
    protected $fillable = [
        'name',
        'cases',
        'deaths',
        'country_id'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
