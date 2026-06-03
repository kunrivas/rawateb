<?php

namespace App\Http\Controllers\Admin;


use App\Models\adm;
use App\Helper\CMPDF;
use App\Models\employee;
use App\Models\megration;
use App\Models\ta_megration;
use App\Models\tamadres_megration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function index(Request $request)
    {
        $adms = adm::all();
        //variable search has the input from search input
        $search = $request->input('search');


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
        return view('admin/deduction/employees-list', ["employees" => $employees, "adms" => $adms, "select_adms" => $select_adms, "select_sitpai" => $select_sitpai, "search" => $search]);
    }

    public function deduction_single_list($MATRI)
    {
        //one record (first)
        $employee = employee::where("MATRI", $MATRI)->first();
        //all the records (get)
        // dd(1);
        //$deduction_singles = tamadres_megration::with("ta_megration")->where("MATRI", $MATRI)->get();
        //passing 2 variables (employee, tamadres_singles) with returning view salary/single/list
        return view('admin/deduction/single/list', ["employee" => $employee]);
    }

    public function deduction_single_year_print(Request $request)
    {
        $employee = employee::where('MATRI', $request->MATRI)->firstOrFail();

        $allowedTypes = [399, 397, 398, 301];
        $type = intval($request->input('IND', 399));
        if (!in_array($type, $allowedTypes, true)) {
            $type = 399;
        }

        $typeLabels = [
            399 => 'الخدمات الاجتماعية',
            397 => 'اقتطاع 397',
            398 => 'اقتطاع 398',
            301 => 'اقتطاع 301',
        ];

        // all megrations of selected year
        $megrations = megration::where('YEAR', $request->YEAR)
            ->orderBy('MONTH', 'desc')
            ->get();

        $rows = [];
        $total = 0;

        foreach ($megrations as $megration) {
            $grant = \App\Models\grant::where('MATRI', $employee->MATRI)
                ->where('ID_MEGRATION', $megration->ID_MEGRATION)
                ->where('IND', $type)
                ->first();

            $amount = $grant ? $grant->MONTANT : 0;
            $total += $amount;

            $rows[] = [
                'year'   => $megration->YEAR,
                'month'  => $megration->MONTH,
                'amount' => $amount,
            ];
        }

        $data = [
            'employee'   => $employee,
            'year'       => $request->YEAR,
            'rows'       => $rows,
            'total'      => $total,
            'ind'        => $type,
            'indLabel'   => $typeLabels[$type] ?? 'غير محدد',
        ];

        $mpdf = new CMPDF();
        $mpdf->initialize(['default_font' => 'aegyptus']);
        $mpdf->viewToPDF('admin/deduction/single/pdf-year', $data);
        $mpdf->outPut('I');
    }
}
