<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dir_absence_reservation_employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employee(){
        return $this->hasOne(employee::class,"MATRI","MATRI");
    }
    public function dir_absence_reservation()
    {
        return $this->belongsTo(dir_absence_reservation::class,"dir_absence_reservation_id","dir_absence_reservation_id");
    }
       public function absence_reservation_employee()
    {
        return $this->belongsTo(absence_reservation_employee::class,"id_absence_reservation_employee","id");
    }
}
