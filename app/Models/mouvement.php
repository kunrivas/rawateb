<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mouvement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne( employee::class,"MATRI","MATRI");
    }
    
    public function out_employees()
    {
        return $this->hasMany( employee::class,"MATRI","MATRI")->where("AFFECT",$this->ESTAB_FROM)->where("mouvement.STATUS","0");
    }

    public function in_employees()
    {
        return $this->hasMany( employee::class,"MATRI","MATRI")->where("AFFECT",$this->ESTAB_TO);
    }

    public function from_establishment()
    {
        return $this->belongsTo(establishment::class,'ESTAB_FROM','estab_rawateb_user');
    }
    
    public function to_establishment()
    {
        return $this->belongsTo(establishment::class,'ESTAB_TO','estab_rawateb_user');
    }


   /*  public function old_rap_rend_rasit()
    {
        return $this->hasOne(rap_rend_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "A");
    }    */
}
