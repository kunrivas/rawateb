<?php

////////*********//////
namespace App\Http\Controllers\Admin\settings;
use App\Http\Controllers\Controller;

use App\Models\adm;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes =      Note::all();

        return view("admin.settings.notes.list", ["notes" => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.settings.notes.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = Note::create([
            "type" => $request->type,
            "text" => $request->text
        ]);
        return redirect()->route("admin-settings-notes");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $notes = Note::all();
        return   $notes;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function show(adm $adm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function edit(adm $adm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, adm $adm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\adm  $adm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Note::destroy($request->id);
        return redirect()->route("admin-settings-notes");
    }
}
