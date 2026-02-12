<?php

namespace App\Http\Controllers\Root;

use App\Models\adm;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;



class UserController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $search = $request->input('search');




        $users =   User::query();

        if (isset($search) && !empty($search)) {
            $users =    $users->where(function ($query) use ($search) {
                $query->where('user_fullname', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('user_mobile', 'like', '%' . $search . '%')
                    ->orWhere('user_email', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);

        $users =  $users->paginate(12);
        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all users
        without search conditions */
        $users->appends(['search' => $search]);

        // returning view users-list with passing parametre users
        //dd($adms_select);
        return view('root.users.user-list', ["users" => $users, "search" => $search]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::where("id", $request->id)->first();
        return view('root.users.edit', ["user" => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function activities(Request $request)
    {
        $search = $request->input('search');
        $activities = [];
        return view('root.users.activities', ["search" => $search, "activities" =>  $activities]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_fullname" => "required",
            "user_profession_code" => "required",
            "user_status" => "required",
            "user_profession" => "required",
            "user_mobile" => "required",
            "user_email" => "required",

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user_data = $request->except("_token");
        $user = User::where("id", $user_data["id"])->first();
        if ($user) {
            $user->user_fullname = $user_data["user_fullname"];
            $user->user_profession_code = $user_data["user_profession_code"];
            $user->user_profession = $user_data["user_profession"];
            $user->user_status = $user_data["user_status"];
            $user->user_mobile = $user_data["user_mobile"];
            $user->user_email = $user_data["user_email"];
            $user->save();
            return redirect()->route("root-user-list");
        }
    }
    public function delete($MATRI)
    {

        $user = user::where("MATRI", $MATRI)->first();
        if ($user) {
            $user->AFFECT = 0;
            $user->save();
            return redirect()->route("settings-user-list");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }
}
