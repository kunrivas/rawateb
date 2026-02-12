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
    @foreach ($absence_reservation_employeess as $adm => $absence_reservation_employees)
        <div align="center">
            <table style="width:920px;" class="font16" >

                <tr>
                    <td colspan="6" class="aligncenter font24"> الجمهورية الجزائرية الديمقراطية الشعبية </td>
                </tr>
                <tr>
                    <td colspan="6" class="aligncenter font24"> وزارة التربية الوطنية </td>
                </tr>
                <tr>
                    <td colspan="3" class="font16"> مديرية التربية لولاية الوادي </td>
                    <td colspan="3">   الإدارة رقم: <span>{{ $adm }}</span></td>

                </tr>
                <tr>
                    {{-- <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td> --}}
                    <td colspan="3" class="font16"> مصلحة تسيير نفقات المستخدمين </td>
                    <td colspan="3" class="font16">  السنة: <span>{{ $current_absence_reservation->YEAR }}</span></td>
                </tr>
                <tr>
                    {{-- <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td> --}}
                    <td colspan="3" class="font16"> </td>
                    <td colspan="3" class="font16">  الشهر: <span>{{ Mlibrary::getArabicMonth($current_absence_reservation->MONTH) }}</span></td>
                </tr>
             
               
                <tr>

                    <td colspan="6" class="aligncenter font24">
                   قائمة الخصم
                    </td>
                </tr>

            </table>

            <table class="case">
                <thead>

                    <tr>
                        <td bgcolor="PaleGoldenrod">#</td>
                        <td bgcolor="PaleGoldenrod">الرمز</td>
                    {{--     <td bgcolor="PaleGoldenrod">الإدارة</td> --}}
                        <td bgcolor="PaleGoldenrod">الإسم</td>
                        <td bgcolor="PaleGoldenrod"> اللقب </td>                        
                        <td bgcolor="PaleGoldenrod">المؤسسة</td>
                        <td bgcolor="PaleGoldenrod" >الوظيفة</td>
                        <td bgcolor="PaleGoldenrod"> عدد الأيام </td>
                        <td bgcolor="PaleGoldenrod"> من </td>
                        <td bgcolor="PaleGoldenrod"> إلى  </td>
                        <td bgcolor="PaleGoldenrod"> السبب </td>
                      
                       
                       

                    </tr>

                </thead>
                <tbody>

                    @if (!empty($absence_reservation_employees))
                        @foreach ($absence_reservation_employees as $key => $absence_reservation_employee)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $absence_reservation_employee->MATRI }}</td>
                              {{--   <td>{{ $absence_reservation_employee->ADM }}</td> --}}
                                <td>{{ $absence_reservation_employee->PRENOMA }}</td>
                                <td>{{ $absence_reservation_employee->NOMA }}</td>                            
                                <td>{{ $absence_reservation_employee->employee->establishment->estab_ar_name ?? '' }}</td>
                                <td>{{ $absence_reservation_employee->employee->fonction->LIBTABA ?? '/' }}</td>
                               {{--  <td>{{ $absence_reservation_employee->SITFAM }}</td>
                                <td>{{ $absence_reservation_employee->CATEG }}</td>
                                <td>{{ $absence_reservation_employee->ECH }}</td> --}}
                                <td>{{ $absence_reservation_employee->NBR_DAYS }}</td>
                                <td>{{ $absence_reservation_employee->DAY_FROM }}</td>
                                <td>{{ $absence_reservation_employee->DAY_TO }}</td>
                                <td>{{ Mlibrary::getAbsenceType($absence_reservation_employee->ABSENCE_TYPE) }}</td>
                              
                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="14">There are no data.</td>

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
                <td dir="ltr" colspan="1" class="font16">تأشيرة المصلحة &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; إمضاء المدير</td>
            </tr>

        </table>
         @if ($absence_reservation_employeess->last() != $absence_reservation_employeess[$adm])
            <pagebreak />
        @endif  
    @endforeach

</body>

</html>
