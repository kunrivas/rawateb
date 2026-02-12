<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rappel_rasit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rappel_megration()
    {
        return $this->belongsTo(rappel_megration::class,"MATRI","MATRI")->where("ID_MEGRATION_RA",$this->ID_MEGRATION_RA)->where("ADM",$this->ADM)->where("SEQ",$this->SEQ);
    }

    public function ra_megration()
    {
        return $this->belongsTo(ra_megration::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }

    public function fonction()
    {
        return $this->belongsTo(fonction::class,"CODEFONC","CODEFONC");
    }
}
