<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absence_reservation_employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function employee(){
        return $this->hasOne(employee::class,"MATRI","MATRI");
    }
    public function absence_reservation()
    {
        return $this->belongsTo(absence_reservation::class,"absence_reservation_id","absence_reservation_id");
    }
}
