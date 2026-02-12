<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_megration extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function establishemnet()
    {
        return $this->belongsTo(establishment::class,'AFFECT','estab_rawateb_user');
    }

    public function employee()
    {
        return $this->belongsTo(employee::class,"MATRI","MATRI");
    }

    public function fonction()
    {
        return $this->belongsTo(fonction::class,"CODEFONC","CODEFONC");
    }

    public function adm()
    {
        return $this->belongsTo(adm::class,"ADM","ADM");
    }

    public function megration()
    {
        return $this->belongsTo(megration::class,"ID_MEGRATION","ID_MEGRATION");
    }

    public function grants()
    {
        return $this->hasMany(grant::class,"MATRI","MATRI")->where("ID_MEGRATION",$this->ID_MEGRATION)->where("ADM",$this->ADM);
    }

}
