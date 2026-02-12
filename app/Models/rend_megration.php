<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rend_megration extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function establishement()
    {
        return $this->belongsTo(establishement::class,'AFFECT','estab_rawateb_user');
    }

    public function employee()
    {
        return $this->belongsTo(employee::class,"MATRI","MATRI");
    }

    public function fonction()
    {
        return $this->belongsTo(fonction::class,"CODFONC","CODEFONC");
    }
    
    public function adm()
    {
        return $this->belongsTo(adm::class,"ADM","ADM");
    }

    public function re_megration()
    {
        return $this->belongsTo(re_megration::class,"ID_MEGRATION_RE","ID_MEGRATION_RE");
    }

       

}
