use App\Helper\Mlibrary;
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


</head>
<style>
    body {
        font-family: "arial";
        direction: rtl;
        font-size: 10px;
    }

    .case {

        width: 100%;
        border-collapse: collapse;
    }

    table.case tr td {
        text-align: center;
        border: 1px solid #000000;
        height: 40px;
    }

    .compt {
        width: 55%;
        border-collapse: collapse;
    }

    table.compt,
    td td {
        text-align: center;
        border: 1px solid #000000;
    }

    .aligncenter {
        text-align: center;
        height: 30px;
    }

    table thead tr td {
        font-weight: bold;
        /*background-color:Aqua;*/
    }

    .font14 {
        font-size: 14px;
        font-weight: bold;
        /* height:25px; */
    }

    .font16 {
        font-size: 16px;
        font-weight: bold;
        line-height: 20px
            /* height:25px; */
            /* text-align: center; */
    }

    .rigth {
        text-align: right;
    }

    .left {
        text-align: left;
    }

    .font18 {
        font-size: 18px;
        font-weight: bold;
        height: 20px;
    }

    .font24 {
        font-size: 24px;
        font-weight: bold;
        height: 30px;
    }

    .barcode {
        font-size: 16px;
        font-family: idcode39;
    }
</style>

<body>

    <div align="center">
        <table style="width:920px;" class="font16">

            <tr>
                <td colspan="6" class="aligncenter font24"> الجمهورية الجزائرية الديمقراطية الشعبية </td>
            </tr>
            <tr>
                <td colspan="6" class="aligncenter font24"> وزارة التربية الوطنية </td>
            </tr>
            <tr>
                <td colspan="3" class="font16"> مديرية التربية لولاية الوادي </td>
                <td colspan="3" class="font16"> الإطار: <span>{{ $employee->fonction->LIBTABA ??'' }}</span></td>

            </tr>
            <tr>
                {{-- <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td> --}}
                <td colspan="3" class="font16"> مصلحة الموظفين </td>
                <td colspan="3" class="font16"> رمز الموظف: <span>{{ $employee->MATRI }}</span></td>

            </tr>
            <tr>
                {{-- <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td> --}}
                <td colspan="3" class="font16">مكتب العطل و الغيابات </td>

            </tr>
            <tr>
                {{-- <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td> --}}
                <td colspan="3" class="font16">الرقم :&nbsp;
                    &nbsp; &nbsp;/ م ع غ /{{ \Carbon\Carbon::now()->year }} </td>

            </tr>


            <tr>

                <td colspan="6" class="aligncenter font24">
                    كشف الغياب للموظف :<span>{{ $employee->PRENOMA }} {{ $employee->NOMA }}</span>
                </td>
            </tr>

        </table>

        <table class="case">
            <thead>

                <tr>
                    <td bgcolor="PaleGoldenrod">#</td>
                    <td bgcolor="PaleGoldenrod">الرمز</td>
                   {{--  <td bgcolor="PaleGoldenrod">الإسم</td>
                    <td bgcolor="PaleGoldenrod"> اللقب </td> --}}
                    <td bgcolor="PaleGoldenrod"> عدد الأيام </td>
                    <td bgcolor="PaleGoldenrod"> من </td>
                    <td bgcolor="PaleGoldenrod"> إلى </td>
                    <td bgcolor="PaleGoldenrod"> الشهر </td>
                    <td bgcolor="PaleGoldenrod"> السبب </td>




                </tr>

            </thead>
            <tbody>

                @if ($absence_reservation_employees && $absence_reservation_employees->isNotEmpty())

                    @foreach ($absence_reservation_employees as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>{{ $value->MATRI }}</td>
                         {{--    <td>{{ $value->PRENOMA }}</td>
                            <td>{{ $value->NOMA }}</td> --}}
                            {{-- <td>{{ $value->employee->establishment->estab_ar_name ?? '' }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '/' }}</td> --}}
                            {{--  <td>{{ $value->SITFAM }}</td>
                                <td>{{ $value->CATEG }}</td> --}}

                            <td>{{ $value->NBR_DAYS }}</td>
                            <td>{{ $value->DAY_FROM }}</td>
                            <td>{{ $value->DAY_TO }}</td>
                            <td>{{ Mlibrary::getArabicMonth($value->absence_reservation->MONTH) }}</td>
                            <td>{{ Mlibrary::getAbsenceType($value->ABSENCE_TYPE) }}</td>

                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td colspan="9">لا يوجد لديه غياب</td>

                    </tr>
                @endif
            </tbody>

        </table>

    </div>

    <table class="singtor">
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>


        <tr>
            <td></td>
        </tr>
        <tr>
            <td dir="ltr" class="font16">الوادي في : {{ date('Y/m/d') }} &nbsp;&nbsp; &nbsp; &nbsp;
                &nbsp;
                &nbsp;&nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</td>
        </tr>
        <tr>
            <td dir="ltr" colspan="1" class="font16">  ع ط / مدير التربية &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>
        </tr>

    </table>
    {{--   @if ($absence_reservation_employeess->last() != $absence_reservation_employeess[$adm])
            <pagebreak /> 
        @endif  --}}
    {{--  @endforeach --}}

</body>

</html>
