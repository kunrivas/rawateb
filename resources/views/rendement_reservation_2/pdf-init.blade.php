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
        height: 25px;
        font-size: 14px;

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
        line-height: 40px
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
        line-height: 40px
    }

    .font24 {
        font-size: 24px;
        font-weight: bold;
        height: 30px;
    }

    .font30 {
        font-size: 30px;
        font-weight: bold;
        height: 50px;
    }

    .barcode {
        font-size: 16px;
        font-family: idcode39;
    }

</style>

<body>
    @foreach ($rendement_reservations_adms as $adm => $rendement_reservations_employees)
        <div align="center">
            <table style="width:920px;" class="font16">
                <tr>
                    <td colspan="4" class="aligncenter font30"> الجمهورية الجزائرية الديمقراطية الشعبية </td>

                </tr>
                <tr>
                    <td colspan="4" class="aligncenter font30"> وزارة التربية الوطنية </td>
                </tr>
                <tr>
                    <td colspan="3" class="font18"> مديرية التربية لولاية الوادي </td>
                    <td> الادارة رقم : {{ $adm }}</td>
                </tr>
                <tr>
                    <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td>
                </tr>
                <tr>
                    <td> <span>رمز المؤسسة</span> <span>{{ $establishment->estab_rawateb_user }}</span> </td>
                </tr>
                <tr>
                    <td colspan="4" class="aligncenter font24">نقاط المردودية
                        {{ Mlibrary::getRendament($rendementReservation->TRIMESTRE) }}
                        {{ $rendementReservation->year }} </td>
                </tr>
            </table>
            <table class="case">
                <thead>
                    <tr class="">
                        <td bgcolor="PaleGoldenrod">#</td>
                        <td bgcolor="PaleGoldenrod">الرمز</td>
                        <td bgcolor="PaleGoldenrod">الاسم واللقب </td>
                        <td bgcolor="PaleGoldenrod">الرتبة</td>
                        <td bgcolor="PaleGoldenrod">الغياب </td>
                        <td bgcolor="PaleGoldenrod">النقطة </td>
                    </tr>

                </thead>
                <tbody>

                    @if (!empty($rendement_reservations_employees))
                        @foreach ($rendement_reservations_employees as $key => $rendement_reservations_employee)
                            <tr>
                                <td style="width: 5%;">{{ $key + 1 }}</td>
                                <td style="width: 12%;">{{ $rendement_reservations_employee->MATRI }}</td>
                                <td style="width: 30%;">{{ $rendement_reservations_employee->employee->NOMA }} {{ $rendement_reservations_employee->employee->PRENOMA }}</td>
                                <td style="width: 7%;">{{ $rendement_reservations_employee->employee->fonction->CATEG ?? '/' }}</td>
                                <td style="width: 7%;">
                                    {{   $rendement_reservations_employee->abs}}</td>
                                    <td style="width: 7%;">{{  $rendement_reservations_employee->point }}</td>
                                </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="6">There are no data.</td>

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
                <td dir="ltr" class="font16">الوادي في : {{ date('Y/m/d') }} &nbsp;&nbsp; &nbsp; &nbsp;
                    &nbsp;
                    &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td dir="ltr" colspan="1" class="font16">المسير المالي &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp;
                    &nbsp; &nbsp;&nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; المدير</td>
            </tr>

        </table>
        @if ($rendement_reservations_adms->last() != $rendement_reservations_adms[$adm])
            <pagebreak />
        @endif
    @endforeach
</body>

</html>
