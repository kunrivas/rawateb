<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>كشف المخلف الجماعي</title>


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
                <td>كشف المخلف الجماعي ل: {{ $current_megration->TITLE }}
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
                    <td bgcolor="PaleGoldenrod"> اللقب , الإسم </td>
                    <td bgcolor="PaleGoldenrod">المبلغ الخام الجديد</td>
                    <td bgcolor="PaleGoldenrod">المبلغ الخام القديم</td>
                    <td bgcolor="PaleGoldenrod">الفرق (الخام)</td>
                    <td bgcolor="PaleGoldenrod">الصافي المدفوع الجديد</td>
                    <td bgcolor="PaleGoldenrod">الصافي المدفوع القديم</td>
                    <td bgcolor="PaleGoldenrod">الفرق (الصافي)</td>
                </tr>

            </thead>
            <tbody>

                @if (!empty($data))
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $value['matri'] }}</td>
                            <td>{{ $value['fullName'] }}</td>
                            <td> {{ number_format($value['new_gross'], 2) }}</td>
                            <td> {{ number_format($value['old_gross'], 2) }}</td>
                            <td> {{ number_format($value['new_gross'] - $value['old_gross'], 2) }}</td>
                            <td> {{ number_format($value['new_net'], 2) }}</td>
                            <td> {{ number_format($value['old_net'], 2) }}</td>
                            <td> {{ number_format($value['new_net'] - $value['old_net'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td colspan="8">There are no data.</td>

                    </tr>

                @endif
            </tbody>

        </table>
        <div>
        </div>
    </div>
</body>

</html>
