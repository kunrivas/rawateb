<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rap_rend_rasit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rap_rend_megration()
    {
        return $this->belongsTo(rap_rend_megration::class,"MATRI","MATRI")->where("ID_MEGRATION_RA_RE",$this->ID_MEGRATION_RA_RE_RE)->where("ADM",$this->ADM)->where("SEQ",$this->SEQ);
    }

    public function ra_re_megration()
    {
        return $this->belongsTo(ra_re_megration::class,"ID_MEGRATION_RA_RE","ID_MEGRATION_RA_RE");
    }

    public function fonction()
    {
        return $this->belongsTo(fonction::class,"CODEFONC","CODEFONC");
    }
}
