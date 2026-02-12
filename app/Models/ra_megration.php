<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ra_megration extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey="ID_MEGRATION_RA";
    public function rappel_megrations()
    {
        return $this->hasMany(rappel_megration::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }

    public function rappel_rasits()
    {
        return $this->hasMany(rappel_rasit::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }

    public function rappel_grants()
    {
        return $this->hasMany(rappel_grant::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }

    public function rappel_grant_dues()
    {
        return $this->hasMany(rappel_grant_due::class,"ID_MEGRATION_RA","ID_MEGRATION_RA");
    }


}
