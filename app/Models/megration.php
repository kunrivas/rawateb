<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class megration extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = "ID_MEGRATION";


    public function re_megration()
    {
        return $this->belongsTo(re_megration::class,"ID_MEGRATION_RE","ID_MEGRATION_RE");
    }


    public function emp_megrations()
    {
        return $this->hasMany(emp_megration::class, "ID_MEGRATION", "ID_MEGRATION");
    }
}
