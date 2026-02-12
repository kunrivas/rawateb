<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>قائمة بيانات الموظوفين</title>
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
        line-height: 30px
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
        line-height: 30px
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
    @if (count($employees) > 0)
        {{-- to devide evert adm group in single page 
        the tamadres_reservation_employees is grouped by adm in controller --}}
        @foreach ($employees as $adm => $data)
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
                        <td colspan="3" class="font16"> إلى السيد :مدير التربية </td>

                    </tr>
                    <tr>
                        <td colspan="3"> <span>المؤسسة: </span><span>{{ $establishment->estab_ar_name }}</span></td>
                        <td colspan="3" class="font16"> مصلحة تسيير نفقات المستخدمين </td>
                    </tr>
                    <tr>
                        <td> <span>رمز المؤسسة</span> <span>{{ $establishment->estab_rawateb_user }}</span> </td>

                    </tr>
                    <tr>
                        <td> <span> الإدارة :</span> <span>{{ $adm }}</span>

                    </tr>
                  {{--   <tr>
                        <td> <span>رقم الهاتف :</span> <span> {{ $phone }} </span> </td>

                    </tr> --}}


                </table>

               

                <table class="case">
                    <thead>
                        <tr class="">
                            <td bgcolor="PaleGoldenrod">الرقم</td>
                            <td bgcolor="PaleGoldenrod">الرمز</td>
                            <td bgcolor="PaleGoldenrod">الاسم واللقب </td>
                            <td bgcolor="PaleGoldenrod">رقم الضمان الاجتماعي</td>
                           {{--  <td bgcolor="PaleGoldenrod">Nom et Prénom</td> --}}
                            <td bgcolor="PaleGoldenrod">تاريخ الميلاد</td>
                            
                            <td bgcolor="PaleGoldenrod">رقم التعريف الوطني (NIN)</td>
                           {{--  <td bgcolor="PaleGoldenrod">RIB</td> --}}
                         {{--    <td bgcolor="PaleGoldenrod">العنوان</td> --}}
                            {{--  <td bgcolor="PaleGoldenrod">الوظيفة</td>
                            <td bgcolor="PaleGoldenrod">الصنف </td>
                            <td bgcolor="PaleGoldenrod">الدرجة </td>
                            <td bgcolor="PaleGoldenrod">الحالة العائلية </td>
                            <td bgcolor="PaleGoldenrod">عدد المتمدرسين </td>
                            <td bgcolor="PaleGoldenrod"> الملاحظة</td> --}}

                        </tr>

                    </thead>
                    <tbody>

                        @if (!empty($data))
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td style="width: 5%;">{{ $key + 1 }}</td>
                                    <td style="width: 12%;">{{ $value->MATRI }}</td>
                                    <td style="width: 20%;">{{ $value->NOMA }} {{ $value->PRENOMA }}</td>
                              {{--       <td style="width: 20%;">{{ $value->NOMPRENOM }}</td> --}}
                                   <td style="width: 12%;">{{ $value->NUMSS }}</td>
                                    <td style="width: 12%;">{{ $value->DATNAIS }}</td>
                                  {{--   <td style="width: 12%;">{{ $value->NUMSS }}</td> --}}
                                    <td style="width: 20%;">{{ $value->NIN }}</td>
                                {{--     <td style="width: 18%;">{{ $value->RIB }}</td>
                                    <td style="width: 20%;">{{ $value->address }}</td> --}}
                                </tr>
                            @endforeach
                        @else
                            <tr>

                                <td colspan="10">There are no data.</td>

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
                    <td dir="ltr" colspan="1" class="font16">المسير المالي &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp; &nbsp;&nbsp;
                        &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                        &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; المدير</td>
                </tr>

            </table>
            @if ($employees->last() != $employees[$adm])
                <pagebreak />
            @endif
        @endforeach
    @else
        <table style="width:920px;" class="font16">
            <tr>
                <td>لا يوجد منح </td>
            </tr>
        </table>
    @endif
</body>

</html>
