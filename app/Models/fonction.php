<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fonction extends Model
{
    use HasFactory;
    protected $primaryKey = 'CODEFONC';      // المفتاح الأساسي الحقيقي في الجدول
    public $incrementing = false;            // لأن CODEFONC ليس Auto Increment
    protected $keyType = 'string';           // أو 'int' إذا CODEFONC رقم
    protected $guarded = []; // الأعمدة الغير القابلة للتحديث

    public function employees()
    {
        return $this->hasMany( employee::class,"CODEFONC","CODEFONC");
    }

    public function emp_megrations()
    {
        return $this->hasMany(emp_megration::class,"CODEFONC","CODEFONC");
    }
    public function rap_rend_megrations()
    {
        return $this->hasMany(emp_megration::class,"CODEFONC","CODEFONC");
    }

    public function rappel_megrations()
    {
        return $this->hasMany(rappel_megration::class,"CODEFONC","CODEFONC");
    }


}
