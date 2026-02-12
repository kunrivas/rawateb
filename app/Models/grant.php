<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grant extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table="grants_new";
    public function emp_megration()
    {
        return $this->belongsTo(emp_megration::class,"MATRI","MATRI")->where("ID_MEGRATION",$this->ID_MEGRATION)->where("ADM",$this->ADM);
    }

    public function megration()
    {
        return $this->belongsTo(megration::class,"ID_MEGRATION","ID_MEGRATION");
    }

    public function grant_info()
    {
        return $this->belongsTo(grant_info::class,"IND","IND");
    }

}
