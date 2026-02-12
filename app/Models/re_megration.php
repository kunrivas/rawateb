<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class re_megration extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = "ID_MEGRATION_RE";

    public function rend_megrations()
    {
        return $this->hasMany(rend_megration::class,"ID_MEGRATION_RE","ID_MEGRATION_RE");
    }
}
