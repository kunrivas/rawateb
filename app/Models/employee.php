<?php

namespace App\Models;

use App\Models\establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class employee extends Model
{
    use HasFactory;
    protected $guarded = [];




    public function establishment()
    {
        return $this->belongsTo(establishment::class, 'AFFECT', 'estab_rawateb_user');
    }

    public function emp_megrations()
    {
        return $this->hasMany(emp_megration::class, "MATRI", "MATRI");
    }
    public function rap_rend_megrations()
    {
        return $this->hasMany(emp_megration::class, "MATRI", "MATRI");
    }

    public function rappel_megrations()
    {
        return $this->hasMany(rappel_megration::class, "MATRI", "MATRI");
    }
    public function fonction()
    {
        return $this->belongsTo(fonction::class, "CODEFONC", "CODEFONC");
    }

    public function adm()
    {
        return $this->belongsTo(adm::class, "ADM", "ADM");
    }

    public function workCount($rendementReservation)
    {
        return  DB::table('emp_megrations')
        ->join('megrations', 'megrations.ID_MEGRATION', '=', 'emp_megrations.ID_MEGRATION')
        ->where("emp_megrations.MATRI", "=", $this->MATRI)
        ->WhereIN("megrations.MONTH", $rendementReservation->getMonths())
        ->Where("megrations.YEAR", $rendementReservation->year)
        ->groupBy("emp_megrations.MATRI")->select(DB::raw('SUM(emp_megrations.NBRTRAV) as NBRTRAV'))->first()->NBRTRAV ?? 0; ;
    }
}
