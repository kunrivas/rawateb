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

    @font-face {
        font-family: barcode;
        src: url('/rawateb/public/fonts/IDAutomationHC39M.ttf');
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
        font-family: barcode;
    }
</style>

<body>

    <div align="center">
        <table style="width:920px;" class="font16">
            <tr>
                <td colspan="4" class="aligncenter font24 "> الجمهورية الجزائرية الديمقراطية الشعبية </td>

            </tr>
            <tr>
                <td colspan="4" class="aligncenter font24"> وزارة التربية الوطنية </td>
            </tr>
            <tr>
                <td colspan="3" class="font16"> مديرية التربية لولاية الوادي </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"> <span>المؤسسة: </span><span>
                        @if (is_null(session()->get('establishment')))
                            /@else{{ session()->get('establishment')->estab_ar_name }}
                        @endif
                    </span></td>
                <td>
                    <img width="150" height="80" src="{{ 'https://quickchart.io/barcode?type=upca&text=' . str_pad($dir_absence_reservation_employee->id, 11, '0', STR_PAD_LEFT) . '&includeText=true' }}" alt="">

                </td>
            </tr>
            <tr>
                <td> <span>رمز المؤسسة</span> <span>
                        @if (is_null(session()->get('establishment')))
                            /@else{{ session()->get('establishment')->estab_rawateb_user }}
                        @endif
                    </span> </td>
            </tr>

            <tr>
                <td colspan="3" class="info"><span> الرمز :</span> <span> {{ $employee->MATRI }}</span> </td>
                <td class="info"><span>رقم الضمان الاجتماعي :</span> <span> {{ $employee->NUMSS }}</span></td>
            </tr>
            <tr>
                <td class="info" colspan="3"><span>اللقب :</span> <span> {{ $employee->NOMA }}</span></td>
                <td class="info"><span>الوظيفة :</span><span>
                        @if (is_null($employee->fonction))
                            / ({{ $employee->ADM }})
                        @else
                            {{ $employee->fonction->LIBTABA }} ({{ $employee->ADM }})
                        @endif
                    </span></td>
            </tr>
            <tr>
                <td class="info" colspan="3"><span>الإسم :</span> <span> {{ $employee->PRENOMA }}</span></td>
                <td class="info"><span>الصنف : </span><span>{{ $employee->CATEG }}</span>
                    <span>الدرجة : </span><span>{{ $employee->ECH }}</span>
                </td>
            </tr>
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
                <td></td>
            </tr>
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
                <td></td>
            </tr>
            <tr>
                <td colspan="6" class="aligncenter font24">
                    إشعار بخصم من الراتب
                </td>
            </tr>
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
                <td></td>
            </tr>
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
                <td></td>
            </tr>
        </table>

        <table class="case">
            <thead>

                <tr>
                    <td bgcolor="PaleGoldenrod">الرمز</td>
                    <td bgcolor="PaleGoldenrod">الإسم</td>
                    <td bgcolor="PaleGoldenrod"> اللقب </td>
                    <td bgcolor="PaleGoldenrod"> عدد الأيام </td>
                    <td bgcolor="PaleGoldenrod"> من </td>
                    <td bgcolor="PaleGoldenrod"> إلى </td>
                    <td bgcolor="PaleGoldenrod"> الشهر </td>
                    <td bgcolor="PaleGoldenrod"> السبب </td>
                </tr>

            </thead>
            <tbody>

                @if ($dir_absence_reservation_employee)
                    <tr>
                        <td>{{ $employee->MATRI }}</td>
                        <td>{{ $employee->PRENOMA }}</td>
                        <td>{{ $employee->NOMA }}</td>
                        <td>{{ $dir_absence_reservation_employee->NBR_DAYS }}</td>
                        <td>{{ $dir_absence_reservation_employee->DAY_FROM }}</td>
                        <td>{{ $dir_absence_reservation_employee->DAY_TO }}</td>
                        <td>{{ Mlibrary::getArabicMonth($dir_absence_reservation_employee->dir_absence_reservation->MONTH) }}
                        </td>
                        <td>{{ Mlibrary::getAbsenceType($dir_absence_reservation_employee->ABSENCE_TYPE) }}</td>
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
            <td></td>
        </tr>
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
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />

            </td>
        </tr>
        <tr>

            <td dir="ltr" class="font14"> في : {{ date('Y/m/d') }} ............... &nbsp;&nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;&nbsp;
                &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td dir="ltr" colspan="1" class="font14">الإمضاء &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                &nbsp;
                &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;

                &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
        </tr>

    </table>
    {{--   @if ($dir_absence_reservation_employeess->last() != $dir_absence_reservation_employeess[$adm])
            <pagebreak />
        @endif  --}}
    {{--  @endforeach --}}

</body>

</html>
