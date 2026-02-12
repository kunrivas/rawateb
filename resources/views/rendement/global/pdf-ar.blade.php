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
                <td colspan="4" class="aligncenter font24"> الجمهورية الجزائرية الديمقراطية الشعبية </td>

            </tr>
            <tr>
                <td colspan="4" class="aligncenter font24"> وزارة التربية الوطنية </td>
            </tr>
            <tr>
                <td colspan="3" class="font16"> مديرية التربية لولاية الوادي </td>
                <td>كشف المردودية الجماعي ل: {{ Mlibrary::getRendament($current_megration->TRIMESTRE) }}
                    {{ $current_megration->YEAR }}</td>
            </tr>
            <tr>
                <td colspan="3"> <span>المؤسسة: </span><span>
                        @if (is_null(session()->get('establishment')))
                            /@else{{ session()->get('establishment')->estab_ar_name }}
                        @endif
                    </span></td>
                @if ($adm != null)
                    <td> <span>الادارة: </span><span>{{ $adm->LIBTABA }}</span></td>
                @endif
            </tr>
            <tr>
                <td> <span>رمز المؤسسة</span> <span>
                        @if (is_null(session()->get('establishment')))
                            /@else{{ session()->get('establishment')->estab_rawateb_user }}
                        @endif
                    </span> </td>
            </tr>

        </table>
     
        <table class="case">
            <thead>
                <tr>
                    <td bgcolor="PaleGoldenrod">الرمز</td>
                    <td bgcolor="PaleGoldenrod">رمز المؤسسة</td>
                    <td bgcolor="PaleGoldenrod">رمز الإدارة</td>
                    <td bgcolor="PaleGoldenrod"> اللقب , الإسم </td>
                    <td bgcolor="PaleGoldenrod">الحالة العائلية</td>
                    <td bgcolor="PaleGoldenrod">الصنف الدرجة </td>
                    <td bgcolor="PaleGoldenrod">أيام العمل </td>
                    <td bgcolor="PaleGoldenrod">الأجر القاعدي</td>
                    <td bgcolor="PaleGoldenrod">الخبرة المهنية</td>
                    <td bgcolor="PaleGoldenrod"> الاجر الرئيسي</td>
                    <td bgcolor="PaleGoldenrod"> خام المردودية </td>
                    <td bgcolor="PaleGoldenrod">إقتطاع الضمان الاجتماعي</td>
                    <td bgcolor="PaleGoldenrod">إقتطاع الضريبة</td>
                    <td bgcolor="PaleGoldenrod">إقتطاعات اخرى </td>
                    <td bgcolor="PaleGoldenrod"> الصافي الدفع</td>
                </tr>

            </thead>
            <tbody>

                @if (!empty($data))
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $value['matri'] }}</td>
                            <td>{{ $value['AFFECT'] }}</td>
                            <td>{{ $value['ADM'] }}</td>
                            <td>{{ $value['fullName'] }}</td>
                            <td>{{ $value['SITFAM'] }}</td>
                            <td>
                                <div>{{ $value['CATEG'] }}</div>
                                <div>{{ $value['ECH'] }}</div>
                            </td>
                            <td> {{ substr($value['JRPRIME'], 0, 2) }}</td>

                            <td> {{ number_format($value['SALBASE'], 2) }}</td>
                            <td> {{ number_format(($value['IEPIND'] ?? 0) * 45, 2) }}</td>
                            <td> {{ number_format($value['SALBASE'] + ($value['IEPIND'] ?? 0) * 45, 2) }}</td>
                            <td> {{ number_format($value['TOTGAIN'], 2) }}</td>
                            <td> {{ number_format($value['RETSS'], 2) }}</td>
                            <td> {{ number_format($value['RETITS'], 2) }}</td>
                            <td> {{ number_format($value['MONTF'] ?? 0, 2) }}</td>
                            <td> {{ number_format($value['NETPAI'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td colspan="10">There are no data.</td>

                    </tr>

                @endif
            </tbody>

        </table>
        <div>
        </div>
    </div>
</body>

</html>
