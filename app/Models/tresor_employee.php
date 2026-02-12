<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tresor_employee extends Model
{

    protected $guarded = [];
    public function employee()
    {
        return $this->hasOne(employee::class, "MATRI", "MATRI");
    }
    public function establishment()
    {
        return $this->setConnection("mysql_user")->hasOne(establishment::class, "id", "establishment_id");
    }
}
