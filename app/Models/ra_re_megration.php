<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ra_re_megration extends Model
{
    use HasFactory;

    protected $guarded = [];
     protected $primaryKey="ID_MEGRATION_RA_RE";

    public function rap_rend_megrations()
    {
        return $this->hasMany(rap_rend_megration::class,"ID_MEGRATION_RA_RE","ID_MEGRATION_RA_RE");
    }
    public function rap_rend_rasits()
    {
        return $this->hasMany(rap_rend_rasit::class,"ID_MEGRATION_RA_RE","ID_MEGRATION_RA_RE");
    }

    public function  rap_rend_grants()
    {
        return $this->hasMany(rap_rend_grant::class,"ID_MEGRATION_RA_RE","ID_MEGRATION_RA");
    }

}
