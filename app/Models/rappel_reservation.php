<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rappel_reservation extends Model
{
    use HasFactory;
    protected $primaryKey ="rappel_reservation_id";
    protected $guarded = [];
    protected $fillable = [
         "YEAR", "TITLE","STATUS"
    ];

}
