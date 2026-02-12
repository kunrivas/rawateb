<?php

namespace App\Http\Controllers\Admin\settings;

use App\Models\fonction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class FonctionController extends Controller
{
    // Display all
    public function index()
    {
        $fonctions = fonction::all();
        // dd($fonctions);
        return view('admin.settings.fonctions.index', ["fonctions" => $fonctions]);
    }

    // Show create form
    public function create()
    {
        return view('admin.settings.fonctions.create');
    }

    // Store new fonction
    public function store(Request $request)
    {  // dd($request);
        $request->validate([
            'CODEFONC' => 'required|unique:fonctions,CODEFONC',
            'LIBTABA' => 'required',
        ]);

        //Fonction::create($request->all());
        $ae = Fonction::create([
            'CODEFONC'             => $request->input('CODEFONC'),
            'LIBTAB'    => $request->input('LIBTAB'),
            'LIBTABA'       => $request->input('LIBTABA'),
            'CATEG'             => $request->input('CATEG'),
            'TAUXPR'          => $request->input('TAUXPR'),
        ]);
        return redirect()->route('admin-settings-fonctions-index')->with('success', 'تمت الإضافة بنجاح');
    }

    // Show one fonction
    /* public function show(Fonction $fonction)
    {
     
    } */

    // Show edit form
    public function edit($CODEFONC)
    {
        $fonction = Fonction::where('CODEFONC', $CODEFONC)->firstOrFail();
        return view('admin.settings.fonctions.edit', compact('fonction'));
    }

    public function update(Request $request, $CODEFONC)
    {

        $fonc = Fonction::where('CODEFONC', $CODEFONC)->firstOrFail();
        $fonc->update([
            'LIBTAB'  => $request->LIBTAB,
            'LIBTABA' => $request->LIBTABA,
            'CATEG'   => $request->CATEG,
            'TAUXPR'  => $request->TAUXPR,
        ]);

        return redirect()->route('admin-settings-fonctions-index')->with('success', 'تم التحديث بنجاح ✅');
    }




    // Delete
    public function destroy($CODEFONC)
    {
        $fonction = Fonction::where('CODEFONC', $CODEFONC)->firstOrFail()->delete();
        return redirect()->route('admin-settings-fonctions-index')->with('success', 'تم حذف الوظيفة بنجاح.');
    }
}
