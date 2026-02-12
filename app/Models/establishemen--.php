<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class establishment extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function employees()
    {
        return $this->hasMany(employee::class,'estab_rawateb_user','AFFECT');
    }

    public function emp_megrations()
    {
        return $this->hasMany(emp_megration::class,'estab_rawateb_user','AFFECT');
    }

    public function rappel_megrations()
    {
        return $this->hasMany(rappel_megration::class,'estab_rawateb_user','AFFECT');
    }

}
