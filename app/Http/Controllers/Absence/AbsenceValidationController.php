<?php

namespace App\Http\Controllers\Absence;

use Illuminate\Http\Request;

use App\Models\absence_reservation;
use App\Http\Controllers\Controller;


class AbsenceValidationController extends Controller
{
    //////////////////////reservation functions////////////////////////////////////////////

    public function index()
    {
        $search = "";

        return view("absence.validation.index", ["search" => $search]);
    }

    public function validation(Request $request)
    {
        $search = $request->barcode;

        return view("absence.validation.index", ["search" => $search]);
    }
}
