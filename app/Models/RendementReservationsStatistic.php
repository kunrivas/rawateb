<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendementReservationsStatistic extends Model
{

    protected $fillable = [
        'rendement_reservations_id', "reserved", "total", "establishment_id", "status","ziroPoint"
    ];

    public function establishment(){
        return $this->setConnection("mysql_user")->hasOne(establishment::class,"id","establishment_id");
    }
}
