<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rappel_grant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function grant_info()
    {
        return $this->belongsTo(grant_info::class,"IND","IND");
    }
    
    function old_rappel_grant()
    {
        return $this->hasOne(rappel_grant::class, 'MATRI', 'MATRI')->where("SEQ", $this->SEQ)->where("IND", $this->IND)->where("ID_MEGRATION_RA", $this->ID_MEGRATION_RA)->where("OLDNEW", "A");
    }

    public function rappel_grant_due()
    {
        return $this->hasOne(rappel_grant_due::class, 'MATRI', 'MATRI')->where("SEQ", $this->SEQ)->where("ID_MEGRATION_RA", $this->ID_MEGRATION_RA)->where("IND", $this->IND);
    }
}
