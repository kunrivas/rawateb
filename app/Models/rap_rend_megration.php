<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rap_rend_megration extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function establishement()
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

    public function ra_re_megration()
    {
        return $this->belongsTo(ra_re_megration::class,"ID_MEGRATION_RA_RE","ID_MEGRATION_RA_RE");
    }
    public function rap_rend_rasits()
    {
        return $this->hasMany(rap_rend_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ);
    }    

    public function new_rap_rend_rasit()
    {
        return $this->hasOne(rap_rend_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "N");
    }   

    public function old_rap_rend_rasit()
    {
        return $this->hasOne(rap_rend_rasit::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->where("OLDNEW", "A");
    }   

    public function rap_rend_grants()
    {
        return $this->hasMany(rap_rend_grant::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE)->where("ADM",$this->ADM)->where("SEQ", $this->SEQ)->orderBy("IND", "ASC");
    }    

    

   

}
