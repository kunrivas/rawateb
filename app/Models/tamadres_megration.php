<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tamadres_megration extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function establishemnet()
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


    public function ta_megration()
    {
        return $this->belongsTo(ta_megration::class,"ID_MEGRATION_TA","ID_MEGRATION_TA");
    }

}
