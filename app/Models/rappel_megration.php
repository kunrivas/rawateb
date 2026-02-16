<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rappel_megration extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function establishemnet()
    {
        return $this->belongsTo(establishement::class,'AFFECT','estab_rawateb_user');
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


    public function ra_megration()
    {
        return $this->belongsTo(ra_megration::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }

    public function rappel_rasits()
    {
        return $this->hasMany(rappel_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ);
    }    

    public function new_rappel_rasit()
    {
        return $this->hasOne(rappel_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "N");
    }   

    public function old_rappel_rasit()
    {
        return $this->hasOne(rappel_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "A");
    }   

    public function rappel_grants()
    {
        return $this->hasMany(rappel_grant::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->orderBy("IND", "ASC");
    }    

    public function new_rappel_grants()
    {
        return $this->hasMany(rappel_grant::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "N")->orderBy("IND", "ASC");
    }   

     
}
