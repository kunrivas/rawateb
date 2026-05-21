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
        return $this->belongsTo(grant_info::class, "IND", "IND");
    }

     public function old_rappel_grant()
{
    return $this->hasOne(rappel_grant::class, 'MATRI', 'MATRI')
    ->where('rappel_grants.OLDNEW', 'A') 
        ->whereColumn('SEQ', 'SEQ')
        ->whereColumn('ID_MEGRATION_RA', 'ID_MEGRATION_RA')
        ->whereColumn('ADM', 'ADM')
        ->whereColumn('IND', 'IND');
}

    public function rappel_grant_due()
{
    return $this->hasOne(rappel_grant_due::class, 'MATRI', 'MATRI')
        ->whereColumn('SEQ', 'SEQ')
        ->whereColumn('ID_MEGRATION_RA', 'ID_MEGRATION_RA')
        ->whereColumn('ADM', 'ADM')
        ->whereColumn('IND', 'IND');
} 
}
