<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ta_megration extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'ID_MEGRATION_TA';

    public function tamadres_megrations()
    {
        return $this->hasMany(tamadres_megration::class,"ID_MEGRATION_TA","ID_MEGRATION_TA");
    }
}
