<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tamadres_reservation_statistic extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function establishment(){
        return $this->setConnection("mysql_user")->hasOne(establishment::class,"id","establishment_id");
    }
}
