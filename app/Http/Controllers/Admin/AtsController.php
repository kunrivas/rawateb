<?php

namespace App\Http\Controllers\Admin;

use App\Models\adm;
use App\Helper\Mlibrary;
use App\Models\employee;
use App\Models\megration;
use App\Models\re_megration;
use Illuminate\Http\Request;
use App\Models\emp_megration;
use App\Models\rend_megration;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class AtsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd( array_keys($request->sitpai));
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        /*var $loginAFFECT is shared by all views  in boot of service provider
        // dd( array_keys($request->sitpai));
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');
        $adms_select = $request->adms_select;

        /*var $loginAFFECT is shared by all views  in boot of service provider
         this the way how to call it in  the controller (difference with call in view)
          $loginAFFECT has the establishement AFFECT value of sign in user */
      
            $employees = employee::with(["establishment", "fonction"]);
      
        //dd($employees);
        $select_adms = [];
        if ($request->has("adms")) {
            $select_adms =  array_keys($request->adms);
            $employees = $employees->whereIn("ADM",  $select_adms);
        }
        $select_sitpai = [0];
        if ($request->has("sitpai")) {
            $select_sitpai =  array_keys($request->sitpai);
            $employees = $employees->whereIn("SITPAI",   $select_sitpai);
        }


        if (isset($search) && !empty($search)) {
            $employees =    $employees->where(function ($query) use ($search) {
                $query->where('NOMA', 'like', '%' . $search . '%')
                    ->orWhere('PRENOMA', 'like', '%' . $search . '%')
                    ->orWhere('MATRI', 'like', '%' . $search . '%');
            });
        }   //to paginate it change ->get by ->paginate(12);

        // dd($employees->toSql());
        $employees =  $employees->paginate(12);
        // Append the search parameter to the pagination links
        /* it resolve the pbm that when i click the cursor of paginator return all employees
         without search conditions */
        $employees->appends(['search' => $search]);

        // returning view employees-list with passing parametre employees
        //dd($adms_select);
        return view('admin/ats/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
        
    }

    public function ats_single_list($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        //$tamadres_singles = tamadres_megration::with("ta_megration")->where("MATRI", $MATRI)->get();
        //passing 2 variables (employee, tamadres_singles) with returning view salary/single/list
        return view('admin/ats/list', ["employee" => $employee]);
    }


    function ats_single_print(Request $request)
    {
        //dd($request);
        $establishment = session()->get("establishment");
        $user = auth()->user();
        $forInformations = $request->boolean("forInformations");
        //  $user = session()->get("data");
        //  dd($request);
        $employee  = employee::where("MATRI", $request->MATRI)->first();
        //dd($employee);
        // $micano = session()->get("data.currentdashboard") != "" ? session()->get("data.currentdashboard") : 391200;
        //  $serv =  Establishment::where('estab_micano', $micano)->first();
        //-------------------------
        //face one
        //-------------------------
        if ($request->clicked === "page1") {



            $data = [
                'forInformations' => $forInformations,
                'bossName' => "مديرية التربية لولاية الوادي", ///$serv->estab_ar_name, //
                'bossId' =>  "39 562 095 41",
                'estabType' => "مؤسسة عمومية ذات طابع اداري", //$serv->estab_type,
                'bossAddress' => $establishment->estab_ar_name ?? "/",
                'employeeName' => $employee->PRENOMA . ' ' . $employee->NOMA,
                'employeeId' =>  $employee->NUMSS,

                'birthDate' => [
                    'y' => ['l' => $employee->DATNAIS[2]?? "/", 'r' => $employee->DATNAIS[3]?? "/"],
                    'm' => ['l' => $employee->DATNAIS[5]?? "/", 'r' => $employee->DATNAIS[6]?? "/"],
                    'd' => ['l' => $employee->DATNAIS[8]?? "/", 'r' =>  $employee->DATNAIS[9]?? "/"]
                ],
                'wilaya' => 'الوادي',
                'employeeAdress' => $establishment->estab_address ?? "/",
                'employeeGrade' => $employee->fonction->LIBTABA ?? "/",
                'hiringDate' => [
                    'y' => ['l' => $employee->DATENT[2]?? "/", 'r' => $employee->DATENT[3]?? "/"],
                    'm' => ['l' => $employee->DATENT[5]?? "/", 'r' => $employee->DATENT[6]?? "/"],
                    'd' => ['l' => $employee->DATENT[8]?? "/", 'r' =>  $employee->DATENT[9]?? "/"]
                ],
                'lastWorkDayDate' => [
                    'y' => ['l' => '/', 'r' => '/'],
                    'm' => ['l' => '/', 'r' => '/'],
                    'd' => ['l' => '/', 'r' => '/']
                ],
                'commanceWorkDate' => [
                    'y' => ['l' => '/', 'r' => '/'],
                    'm' => ['l' => '/', 'r' => '/'],
                    'd' => ['l' => '/', 'r' => '/']
                ],
                'doesntcommanceWorkDate' => [
                    'y' => ['l' => '/', 'r' => '/'],
                    'm' => ['l' => '/', 'r' => '/'],
                    'd' => ['l' => '/', 'r' => '/']
                ],
            ];

            // dd($data);

            return view('admin/ats/ats-page1', $data);
        }

        //-------------------------
        //face two
        //-------------------------
        if ($request->clicked === "page2") {
            // new empty variable called megration as collection
            $megrations = new Collection;

            $monthValue = intval($request->month);
            $yearValue = intval($request->year);
            $numberMonth = intval($request->numberMonth);

            $data = new Collection();

            $cotz = 0;
            $sz = 0;

            /* loop foor to fill the megerations empty collection
            and data empty collection
            by the megration rows of table megration selected by user  */
            for ($i =   $monthValue; $i >= 0 &&  $numberMonth > 0; $i--, $numberMonth--) {
                if ($i == 0) {
                    $i = 12;
                    $yearValue--;
                }

                ////fill the collection megration
                $megration = megration::where('MONTH', $i)->where('YEAR', $yearValue)->first();
                if ($megration) {
                    $megrations->add($megration);

                    ///fill the collection data
                    $emp_megration = emp_megration::where("MATRI", $request->MATRI)
                        ->where("ID_MEGRATION", $megration->ID_MEGRATION)
                        ->first();


                    ///dd($emp_megration);

                    if ($request->has("forRendement")) {
                        // dd(Mlibrary::getTrimestre($i));
                        $re_megration =  re_megration::where('TRIMESTRE', Mlibrary::getTrimestre($i))->where('YEAR', $yearValue)->first();
                        if ($re_megration) {
                            $rend_megration = rend_megration::where("MATRI", $request->MATRI)
                                ->where("ID_MEGRATION_RE", $re_megration->ID_MEGRATION_RE)
                                //->where("ID_MEGRATION_RE", $megration->re_megration->ID_MEGRATION_RE)
                                ->first();
                            // dd($rend_megration);

                            $cotz = Mlibrary::make_currency(($emp_megration->BRUTSS ?? 0) + (($rend_megration->BRUTSS ?? 0) / 3), ",", "");
                            $sz = Mlibrary::make_currency(($emp_megration->RETSS ?? 0) + (($rend_megration->RETSS ?? 0) / 3), ",", "");
                        } else {
                            $cotz = Mlibrary::make_currency($emp_megration->BRUTSS ?? 0, ",", "");
                            $sz = Mlibrary::make_currency($emp_megration->RETSS ?? 0, ",", "");
                        }
                    } else {
                        $cotz = Mlibrary::make_currency($emp_megration->BRUTSS ?? 0, ",", "");
                        $sz = Mlibrary::make_currency($emp_megration->RETSS ?? 0, ",", "");
                    }


                    $data->add((object) [
                        'month' => Mlibrary::getArabicMonth($megration->MONTH),
                        'year' =>  $megration->YEAR,
                        'trimestre' => $re_megration->TRIMESTRE ?? 0,
                        'workdays' => '30',
                        'absensecoz' => '/',
                        'cotz' => $cotz,
                        'sc' => $sz

                    ]);
                }
            }


            if ($request->has("forOrderMonths")) {
                $data = $data->reverse();
            }
            //dd( $megrations);
            // dd($data);

            /*
            $emp_megrations = emp_megration::where("MATRI", $request->MATRI)
            // The map function is used to transform the $megrations collection
            //by extracting the ID_MEGRATION property from each object in the collection.
           // The toArray method is called to convert the resulting collection of ID_MEGRATION values into a plain array.
          // The resulting array is then passed to the whereIn method,
           // filtering records where the "ID_MEGRATION" column matches any value in the array.

            ->whereIn("ID_MEGRATION", $megrations->map(function ($megration) {
                return $megration->ID_MEGRATION;
            })->toArray())
            ->OrderBy("ID_MEGRATION", "desc")->get();


           //dd($emp_megrations);
            $data = new Collection();
            foreach ($emp_megrations  as $key => $emp_megration) {
                $data->add((object) [
                    'month' => Mlibrary::getArabicMonth($megrations[$key]->MONTH),
                    'year' =>  $megrations[$key]->YEAR,
                    'workdays' => '30',
                    'absensecoz' => '/',
                    'cotz' =>   Mlibrary::make_currency($emp_megration->BRUTSS, ",", ""),
                    'sc' =>  Mlibrary::make_currency($emp_megration->RETSS, ",", "")
                ]);
            }
 */

            $data = [
                'nbrMonths'             => $numberMonth,
                'edited_at'             => date('Y/m/d'),
                'location'              => $establishment->estab_office ?? "/",
                'edit_owner'            => $user->user_fullname ?? "/",
                'edit_ownertype'        => $user->user_profession ?? "/",
                /*  calibrator the espace between the lines of table  of affichage of page2 positiion (top)  */
                'calibrator'            => 35,
                /*  y is the first line in the table  of affichage of page2 positiion (top) */
                'y'                     => 155,
                'data'                  => $data, // json_decode(json_encode($data, JSON_FORCE_OBJECT)),

            ];

            //dd($data);

            return view('admin/ats/ats-page2', $data);
        }

        return abort(404);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
