<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rappel_reservation_employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function employee(){
        return $this->hasOne(employee::class,"MATRI","MATRI");
    }
}
