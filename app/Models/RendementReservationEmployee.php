<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendementReservationEmployee extends Model
{

    protected $fillable = [
        'MATRI', "point", "zero_point_reason", "rendement_reservation_id","abs","affect","estab_mail_code"
    ];

    public function employee(){
        return $this->hasOne(employee::class,"MATRI","MATRI");
    }
    public function establishment()
    {
        return $this->belongsTo(establishment::class, 'estab_mail_code', 'estab_mail_code');
    }
}
