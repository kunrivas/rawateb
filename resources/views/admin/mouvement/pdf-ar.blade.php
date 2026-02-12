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
    @foreach ($data as $adm => $mouvEmployees)
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
                </tr>
               
                <tr>
                    <td colspan="3" class="font16"> مصلحة تسيير نفقات المستخدمين </td>
                </tr>
                <tr>
                    <td colspan="3" class="font16"> <span> الإدارة :</span> <span>{{ $adm }}</span></td>
                </tr>
                <tr>          
                    <td colspan="4" class="aligncenter font18"> <span>قائمة الحركة المنجزة </span>
                        <br>
                     @if (!empty($start_date) or !empty($end_date))
                         <span> من: {{$start_date ??'/'}}</span>
                        
                         <span> إلى: {{$end_date ?? '/'}}</span>
                     @else
                         
                     @endif   
                      
                    
                    </td>
                </tr>
            </table>
                 
            <table class="case">
               
                <thead>
                    <tr>
                        <td bgcolor="PaleGoldenrod">الرمز</th>
                        <td bgcolor="PaleGoldenrod">الرتبة </th>
                        <td bgcolor="PaleGoldenrod">الإسم</th>
                        <td bgcolor="PaleGoldenrod">اللقب</th>
                        <td bgcolor="PaleGoldenrod">تاريخ الميلاد</th>
                        <td bgcolor="PaleGoldenrod">رقم الضمان الاجتماعي</th>
                        <td bgcolor="PaleGoldenrod">المؤسسة الجديدة</th>
                        <td bgcolor="PaleGoldenrod">رمز م الجديدة</th>
                        <td bgcolor="PaleGoldenrod">المؤسسة الأصلية</th>
                        <td bgcolor="PaleGoldenrod">رمز م الأصلية</th>
                    </tr>

                </thead>
                <tbody>

                    @if (!empty($mouvEmployees))
                        @foreach ($mouvEmployees as $key => $value)
                            <tr>
                                <td>{{ $value['matri'] }}</td>
                                <td>{{ $value['fonction'] }}</td>
                                <td>{{ $value['firstName'] }}</td>
                                <td>{{ $value['familyName'] }}</td>
                                <td>{{ $value['birthDate'] }}</td>
                                <td>{{ $value['numCnas'] }}</td>
                                <td>{{ $value['newEstab'] }}</td>
                                <td>{{ $value['codeNewEstab'] }}</td>
                                <td>{{ $value['oldEstab'] }}</td>
                                <td>{{ $value['codeOldEstab'] }}</td>


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
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; الإمضاء </td>
            </tr>

        </table>

        @if ($data->last() != $data[$adm])
            <pagebreak />
        @endif
    @endforeach
</body>

</html>
