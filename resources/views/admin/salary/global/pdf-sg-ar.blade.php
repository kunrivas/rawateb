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
    }

    .case {

        width: 100%;
        border-collapse: collapse;
    }

    .singtor {
        width: 100%;
        border-collapse: collapse;
    }

    .singtor,
    .singtor td {
        text-align: center;

        width: 100%;
        border-collapse: collapse;
    }

    table.case,
    td td {
        text-align: center;
        border: 1px solid #000000;
        height: 40px;

    }

    table.case,
    td td {
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

    table tr td.info {
        border-bottom: 1px solid black;
    }

    table tr td.view {
        vertical-align: top;
        /*  font-size: 16px;
      font-weight: bold;
        height: 40px;
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


    /* Add this style to create a page break */
    .page-break {
        page-break-before: always;
    }
</style>

<body>
     
    @foreach ($Collection_emp_megrations_to_print as $item)
       
        <div align="center" class=" {{ $loop->first ? '' : 'page-break' }}">
            <table style="width:920px;" class="font16">
                <tr>
                    <td colspan="4" class="aligncenter font24 "> الجمهورية الجزائرية الديمقراطية الشعبية </td>

                </tr>
                <tr>
                    <td colspan="4" class="aligncenter font24"> وزارة التربية الوطنية </td>
                </tr>
                <tr>
                    <td colspan="3" class="font16"> مديرية التربية لولاية الوادي </td>
                    <td>كشف الراتب لشهر {{ Mlibrary::getArabicMonth($item['salary_single']->megration->MONTH) }}
                        {{ $item['salary_single']->megration->YEAR }}
                    </td>
                </tr>
                <tr>
                    <td> <span>المؤسسة: </span><span>
                            @if (is_null(session()->get('establishment')))
                                /@else{{ session()->get('establishment')->estab_ar_name }}
                            @endif
                        </span></td>
                </tr>
                <tr>
                    <td> <span>رمز المؤسسة</span> <span>
                            @if (is_null(session()->get('establishment')))
                                /@else{{ session()->get('establishment')->estab_rawateb_user }}
                            @endif
                        </span> </td>
                </tr>

                <tr>
                    <td colspan="3" class="info"><span> الرمز :</span> <span>
                            {{ $item['salary_single']->MATRI }}</span>
                    </td>
                    <td class="info"><span>رقم الضمان الاجتماعي :</span> <span>
                            {{ $item['salary_single']->NUMSS }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="info" colspan="3"><span>اللقب :</span> <span>
                            {{ $item['salary_single']->NOMA }}</span>
                    </td>
                    <td class="info"><span>الوظيفة :</span><span>
                            @if (is_null($item['salary_single']->fonction))
                                / ({{ $item['salary_single']->emp_meg_ADM }})
                            @else
                                {{ $item['salary_single']->fonction->LIBTABA }} ({{ $item['salary_single']->ADM }})
                            @endif
                        </span></td>
                </tr>
                <tr>
                    <td class="info" colspan="3"><span>الإسم :</span> <span>
                            {{ $item['salary_single']->PRENOMA }}</span></td>
                    <td class="info"><span>الصنف : </span><span>{{ $item['salary_single']->CATEG }}</span></td>
                </tr>
                <tr>
                    <td class="info" colspan="3"> <span>الحالة العائلية :</span>
                        <span>{{ $item['salary_single']->SITFAM }}</span>
                    </td>
                    <td class="info"><span>الدرجة : </span><span>{{ $item['salary_single']->ECH }}</span></td>
                </tr>
                <tr class="info-last">
                    <td class="info" colspan="3"> <span>تاريخ التوظيف :</span>
                        <span>{{ Mlibrary::getDateFormat($item['salary_single']->DATENT) }}</span>
                    </td>
                    <td class="info" colspan="3"> <span>مكان العمل:</span>
                        <span>{{ $item['salary_single']->AFFECT }}</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" align="right" class="view">


                        <table class="case">
                            <thead>

                                <tr>
                                    <th colspan="2">مكونات الراتب</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($item['salary_grants']['primes']['base'] as $key => $value)
                                    <tr>
                                        <td><b> {{ $value->grant_info->LIBINDA }}</b></td>
                                        <td><b> {{ number_format($value->MONTANT, 2) }}</b> </td>
                                    </tr>
                                @endforeach
                                @foreach ($item['salary_grants']['primes']['other'] as $key => $value)
                                    <tr>
                                        <td> {{ $value->grant_info->LIBINDA }}</td>
                                        <td> {{ number_format($value->MONTANT, 2) }} </td>
                                    </tr>
                                @endforeach
                                @foreach ($item['salary_grants']['primes']['family'] as $key => $value)
                                    <tr>
                                        <td> {{ $value->grant_info->LIBINDA }}</td>
                                        <td> {{ number_format($value->MONTANT, 2) }} </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>مجموع المبلغ الخام </td>
                                    <td> {{ number_format($item['salary_single']->TOTGAIN, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td colspan="2" align="left" class="view">
                        <table class="case">
                            <thead>
                                <tr>
                                    <th colspan="2"> الإقتطاعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (array_key_exists(610, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][610]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][610]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (array_key_exists(980, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][980]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][980]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (array_key_exists(660, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][660]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][660]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (array_key_exists(399, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][399]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][399]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (array_key_exists(397, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][397]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][397]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if (array_key_exists(398, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][398]->grant_info->LIBINDA }}
                                        </td>
                                        <td>{{ number_format($item['salary_grants']['retenues']['inds'][398]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($item['salary_grants']['retenues']['other'] as $key => $value)
                                    <tr>
                                        <td>{{ $value->grant_info->LIBINDA }}</td>
                                        <td>{{ number_format($value->MONTANT, 2) }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td>ايام العمل</td>
                                    <td>{{ $item['salary_single']->NBRTRAV }}</td>
                                </tr>
                                @if (array_key_exists(999, $item['salary_grants']['retenues']['inds']))
                                    <tr>
                                        <td>{{ $item['salary_grants']['retenues']['inds'][999]->grant_info->LIBINDA }}
                                        </td>
                                        <td>
                                            {{ number_format($item['salary_grants']['retenues']['inds'][999]->MONTANT, 2) }}
                                        </td>
                                    </tr>
                                @endif
                        </table>
                    </td>
                </tr>
                <tr style="margin-top:10px">

                <tr>
            </table>

            <table class="singtor">
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td dir="ltr">الوادي في : {{ date('Y/m/d') }} &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;&nbsp;
                        &nbsp;
                        &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;&nbsp;
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
                    <td dir="ltr" colspan="1">الإمضاء &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                        &nbsp;
                        &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                        &nbsp;
                        &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                </tr>

            </table>

        </div>
    
    @endforeach
   

</body>

</html>
