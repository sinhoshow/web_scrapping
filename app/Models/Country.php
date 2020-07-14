<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Country extends Model
{
    protected $fillable = [
        'name',
        'cases',
        'deaths'
    ];

    public function states(){
        return $this->hasMany(State::class);
    }
}
