<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adm extends Model
{
    public function employees()
    {
        return $this->hasMany( employee::class,"ADM","ADM");
    }
    public function emp_megrations()
    {
        return $this->hasMany(emp_megration::class,"CODEFONC","CODEFONC");
    }

    public function rappel_megrations()
    {
        return $this->hasMany(rappel_megration::class,"CODEFONC","CODEFONC");
    }

      
}
