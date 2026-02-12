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
    @foreach ($rappel_reservation_employeess as $adm => $rappel_reservation_employees)
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
                <tr>
                    <td> <span>رقم الهاتف :</span> <span>{{$phone }}</span> </td>



                </tr>
                <tr>

                    <td colspan="6" class="aligncenter font24">كشف تصفية المخلفات لسنة:
                        {{ $current_rappel_reservation->YEAR }}
                        {{ $current_rappel_reservation->TITLE }}</td>

                </tr>

            </table>

            <table class="case">
                <thead>
                    <tr>
                        <td colspan="9" bgcolor="PaleGoldenrod">الحالة القديمة للموظف</td>
                        <td colspan="4" bgcolor="PaleGoldenrod">الحالة الجديدة للموظف</td>
                    </tr>
                    <tr>
                        <td bgcolor="PaleGoldenrod">الرقم</td>
                        <td bgcolor="PaleGoldenrod">الرمز</td>
                        <td bgcolor="PaleGoldenrod">الإدارة</td>
                        <td bgcolor="PaleGoldenrod"> اللقب </td>
                        <td bgcolor="PaleGoldenrod">الإسم</td>
                        <td bgcolor="PaleGoldenrod" style="width: 15%">الوظيفة</td>
                        <td bgcolor="PaleGoldenrod" style="width: 7%">الحالة العائلية</td>
                        <td bgcolor="PaleGoldenrod">الصنف</td>
                        <td bgcolor="PaleGoldenrod">الدرجة</td>
                        <td colspan="2" bgcolor="PaleGoldenrod"> نوع المخلف</td>
                        <td bgcolor="PaleGoldenrod"> تاريخ السريان </td>
                        <td bgcolor="PaleGoldenrod">الملاحظات</td>

                    </tr>

                </thead>
                <tbody>

                    @if (!empty($rappel_reservation_employees))
                        @foreach ($rappel_reservation_employees as $key => $rappel_reservation_employee)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $rappel_reservation_employee->MATRI }}</td>
                                <td>{{ $rappel_reservation_employee->ADM }}</td>
                                <td>{{ $rappel_reservation_employee->NOMA }}</td>
                                <td>{{ $rappel_reservation_employee->PRENOMA }}</td>
                                <td>{{ $rappel_reservation_employee->employee->fonction->LIBTABA ??'/'}}</td>
                                <td>{{ $rappel_reservation_employee->SITFAM }}</td>
                                <td>{{ $rappel_reservation_employee->CATEG }}</td>
                                <td>{{ $rappel_reservation_employee->ECH }}</td>
                                <td>{{ Mlibrary::getRappelType($rappel_reservation_employee->rappel_type) }}</td>
                                <td>{{ $rappel_reservation_employee->rappel_val }}</td>
                                <td>{{ $rappel_reservation_employee->rappel_date }}</td>
                                <td>{{ $rappel_reservation_employee->rapeel_notes }}</td>

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
                <td>
                    ملاحظة 01 :يرفق مع هذا الكشف 3 نسخ من كل وضعية.
                </td>

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
                    &nbsp;  &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    إمضاء المسير المالي
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  الإمضاء المدير</td>
            </tr>

        </table>
        @if ($rappel_reservation_employeess->last() != $rappel_reservation_employeess[$adm])
            <pagebreak />
        @endif
    @endforeach

</body>

</html>
