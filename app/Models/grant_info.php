<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grant_info extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function grants()
    {
        return $this->hasMany(grant::class,"IND","IND");
    }

    public function rappel_grants()
    {
        return $this->hasMany(rappel_grant::class,"IND","IND");
    }

    public function rap_rend_grants()
    {
        return $this->hasMany(rappel_grant::class,"IND","IND");
    }

}
