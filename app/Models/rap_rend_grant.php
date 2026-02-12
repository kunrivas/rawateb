<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rap_rend_grant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function grant_info()
    {
        return $this->belongsTo(grant_info::class,"IND","IND");
    }
    
    
}
