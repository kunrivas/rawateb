<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absence_reservation extends Model
{
    use HasFactory;
    protected $primaryKey ="absence_reservation_id";
    protected $guarded = [];
}
