<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            font-family: "Arial" !important;
        }



        .pos-absolute {
            position: absolute;
        }

        .m-0 {
            margin: 0px;
        }

        .font22 {
            font-size: 22px;
        }

        .font28 {
            font-size: 28px;
        }

        .font32 {
            font-size: 32px;
        }

        .font96 {
            font-size: 96px;
        }

        .rigth {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .border-1 {
            border: 2px solid black;
        }

        .editable {
            background-color: lightpink;
            /* border: 2px solid red; */
        }

        .editable:hover {
            border: 2px solid red;
        }

        .editable-control {
            font-size: medium;
            font-weight: bold;
            border: 2px solid red;
        }

        @media print {
            @page {
                size: auto;
                margin: 0.5cm 0.5cm 0.5cm 0.5cm;
            }

            @page :footer {
                display: none
            }

            @page :header {
                display: none
            }

            body {
                -webkit-print-color-adjust: exact;
            }

            .editable {
                background-color: unset;
                border: unset;
            }

            .editable:hover {
                border: unset;
            }
        }
    </style>
</head>

<body>
    @foreach ($Collection_emp_megrations_to_print as $item)
        <div align="center" class=" {{ $loop->first ? '' : 'page-break' }}">
            <table align="center" style="width:920px;" class="font16">
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
                            {{ $item['employee']->MATRI }}</span>
                    </td>
                    <td class="info"><span>رقم الضمان الاجتماعي :</span> <span>
                            {{ $item['employee']->NUMSS }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="info" colspan="3"><span>اللقب :</span> <span>
                            {{ $item['employee']->NOMA }}</span>
                    </td>
                    <td class="info"><span>الوظيفة :</span><span>
                            @if (is_null($item['salary_single']->fonction))
                                / ({{ $item['salary_single']->ADM }})
                            @else
                                {{ $item['salary_single']->fonction->LIBTABA }} ({{ $item['salary_single']->ADM }})
                            @endif
                        </span></td>
                </tr>
                <tr>
                    <td class="info" colspan="3"><span>الإسم :</span> <span>
                            {{ $item['employee']->PRENOMA }}</span></td>
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
                        <span>{{ Mlibrary::getDateFormat($item['employee']->DATENT) }}</span>
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
