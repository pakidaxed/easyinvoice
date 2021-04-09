<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
