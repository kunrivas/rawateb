<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendementReservation extends Model
{

    protected $fillable = [
        'TRIMESTRE', "year", "status"
    ];

    public function getMonths()
    {


        if ($this->TRIMESTRE == 1)
            return [1, 2, 3];
        if ($this->TRIMESTRE == 2)
            return [4, 5, 6];
        if ($this->TRIMESTRE == 3)
            return [7, 8, 9];
        if ($this->TRIMESTRE == 4)
            return [10, 11, 12];

        return [];
    }
}
