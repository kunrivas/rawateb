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
                <td>كشف الراتب الجماعي لشهر {{ Mlibrary::getArabicMonth($current_megration->MONTH) }}
                    {{ $current_megration->YEAR }}</td>
            </tr>
            <tr>
                <td colspan="3"> <span>المؤسسة: </span><span> @if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_ar_name }}  @endif</span></td>
                @if ($adm != null)
                    <td> <span>الادارة: </span><span>{{ $adm->LIBTABA }}</span></td>
                @endif
            </tr>
            <tr>
                <td> <span>رمز المؤسسة</span> <span>@if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_rawateb_user }}  @endif </span> </td>
            </tr>

        </table>
        <table class="case">
            <thead>
                <tr>
                    <td bgcolor="PaleGoldenrod">الرمز</td>
                    <td bgcolor="PaleGoldenrod">الادارة</td>
                    <td bgcolor="PaleGoldenrod"> اللقب الإسم </td>
                    <td bgcolor="PaleGoldenrod"> الحالة العائلية </td>
                    <td bgcolor="PaleGoldenrod">الصنف الدرجة </td>
                    <td bgcolor="PaleGoldenrod">أيام العمل </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>الأجر القاعدي </div>
                        <div>م.الخبرة المهنية </div>
                        <div>م.المنصب العالي </div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>م.خ البداغوجية</div>
                        <div>م.ت. المالي والمادي</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>م.جزافية</div>
                        <div>م.أ.المشتركة</div>
                        <div>م.ن.الادارية</div>

                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>م.التوثيق </div>
                        <div>م.التأهيل</div>
                        <div>م.ذ.م.بيداغوجية</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>م.السكن</div>
                        <div>م.المنطقة</div>
                        <div>م.المنصب</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>ت.الزام.ش.طبي</div>
                        <div>ت دعم.ن.ش.طبي </div>
                        <div>منحة العدوى</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>الاجر الوحيد</div>
                        <div>المنح العائلية</div>
                        <div>اطفال <10س< /div>
                    </td>
                    <td bgcolor="PaleGoldenrod">الخام</td>
                    <td bgcolor="PaleGoldenrod">
                        <div>الخاضع.ض</div>
                        <div>إ ض.إجتماعي</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>إق.الضريبة</div>
                        <div>اق.التعاضدية</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>الخدمات1</div>
                        <div>الخدمات2</div>
                        <div>حدمات اجتماعية</div>
                    </td>
                    <td bgcolor="PaleGoldenrod">
                        <div>اقتطاع الغياب</div>
                        <div>اقتطاع الاضراب</div>
                        <div>اقتطاع المعارضة</div>
                    </td>
                    <td bgcolor="PaleGoldenrod"> الصافي الدفع</td>
                </tr>

            </thead>
            <tbody>

                @if (!empty($data))
                    @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $value['matri'] }}</td>
                            <td>{{ $value['ADM'] }}</td>
                            <td>{{ $value['fullName'] }}</td>
                            <td>{{ $value['SITFAM'] }}</td>
                            <td>
                                <div>{{ $value['CATEG'] }}</div>
                                <div>{{ $value['ECH'] }}</div>
                            </td>
                            <td>{{ $value['NBRTRAV']}}</td>
                            <td>
                                <div>{{ array_key_exists('V001', $value) ? $value['V001'] : '/' }}</div>
                                <div>{{ array_key_exists('V101', $value) ? $value['V101'] : '/' }}</div>
                                <div>{{ array_key_exists('V105', $value) ? $value['V105'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V103', $value) ? $value['V103'] : '/' }}</div>
                                <div>{{ array_key_exists('V241', $value) ? $value['V241'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V208', $value) ? $value['V208'] : '/' }}</div>
                                <div>{{ array_key_exists('V270', $value) ? $value['V270'] : '/' }}</div>
                                <div>{{ array_key_exists('V273', $value) ? $value['V273'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V290', $value) ? $value['V290'] : '/' }}</div>
                                <div>{{ array_key_exists('V246', $value) ? $value['V246'] : '/' }}</div>
                                <div>{{ array_key_exists('V280', $value) ? $value['V280'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V211', $value) ? $value['V211'] : '/' }}</div>
                                <div>{{ array_key_exists('V225', $value) ? $value['V225'] : '/' }}</div>
                                <div>{{ array_key_exists('V260', $value) ? $value['V260'] : '/' }}</div>
                            </td>

                            <td>
                                <div>{{ array_key_exists('V212', $value) ? $value['V212'] : '/' }}</div>
                                <div>{{ array_key_exists('V213', $value) ? $value['V213'] : '/' }}</div>
                                <div>{{ array_key_exists('V214', $value) ? $value['V214'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V401', $value) ? $value['V401'] : '/' }}</div>
                                <div>{{ array_key_exists('V990', $value) ? $value['V990'] : '/' }}</div>
                                <div>{{ array_key_exists('V991', $value) ? $value['V991'] : '/' }}</div>
                            </td>
                            <td>{{ $value['TOTGAIN'] }}</td>
                            <td>
                                <div>{{ array_key_exists('BRUTSS', $value) ? $value['BRUTSS'] : '/' }}</div>
                                <div>{{ array_key_exists('RETSS', $value) ? $value['RETSS'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V980', $value) ? $value['V980'] : '/' }}</div>
                                <div>{{ array_key_exists('V660', $value) ? $value['V660'] : '/' }}</div>
                            </td>
                            <td>
                                <div>{{ array_key_exists('V397', $value) ? $value['V397'] : '/' }}</div>
                                <div>{{ array_key_exists('V398', $value) ? $value['V398'] : '/' }}</div>
                                <div>{{ array_key_exists('V399', $value) ? $value['V399'] : '/' }}</div>
                            </td>
                            <td>
                                <div>
                                    {{ array_key_exists('V301', $value) ? $value['V301'] : '/' }}
                                </div>
                                <div>
                                    {{ array_key_exists('V302', $value) ? $value['V302'] : '/' }}
                                </div>
                                <div>
                                    {{ array_key_exists('V303', $value) ? $value['V303'] : '/' }}
                                </div>
                            </td>
                            <td>{{ array_key_exists('V999', $value) ? $value['V999'] : '/' }}</td>


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
