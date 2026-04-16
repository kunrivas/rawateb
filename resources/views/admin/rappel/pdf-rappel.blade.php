@php

    $_retenues_inds = [610, 980, 660, 399, 397, 398, 999];
    $_primes_family_inds = [992, 991, 990, 401];
    $_primes_base_inds = [001, 101];
    $v610 = null;
@endphp
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

    table.case td {
        text-align: center;
        border: 1px solid #000000;
        height: 30px;

    }

    table.case th {
        text-align: center;
        border: 1px solid #000000;
        height: 30px;

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
</style>
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
        <td colspan="3"> <span>المؤسسة: </span><span>
                @if (is_null(session()->get('establishment')))
                    /@else{{ session()->get('establishment')->estab_ar_name }}
                @endif
            </span></td>

    </tr>
    <tr>
        <td> <span>رمز المؤسسة:</span> <span>
                @if (is_null(session()->get('establishment')))
                    /@else{{ session()->get('establishment')->estab_rawateb_user }}
                @endif
            </span> </td>
    </tr>
    <tr>
        <td colspan="4" class="aligncenter font24">{{ $rappel->ra_megration->TITLE ?? '/' }}</td>
    </tr>
</table>
<div id="page2print" style="direction: rtl;">

    <!---->
    <div class="arkhat subpage">

        <div class="header">
            <!---->
        </div>
        <br>
        <div id="piece1">
            <table class="ttf" style="width: 100%;">
                <tbody>
                    <tr>
                        <td class="fp-title" style="width: 90px">الإسم واللقب:</td>
                        <td>
                            &nbsp;<b> {{ $rappel->employee->NOMA }} {{ $rappel->employee->PRENOMA }}
                                {{ $rappel->MATRI }} </b>
                        </td>
                        <td style="width: 20%"></td>
                        <td style="text-align: left">السنة المالية:</td>
                        <td> {{ $rappel->ra_megration->YEAR ?? 0 }}</td>
                    </tr>
                    <tr>

                        <td class="fp-title" style="width: 120px">رقم الحساب:</td>
                        <td> <b> <span>{{ $rappel->CLECPT }}</span>
                                <span>/</span><span>{{ $rappel->NUMCPT }}</span></b>
                        <td class="fp-title" style="width: 120px">الضمان الإجتماعي:</td>
                        <td> <b> {{ $rappel->NUMSS }} </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="piece2">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 100%">

                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td colspan="2" style="width: 25%;">
                                            <div style="text-align: center;"><b>أجر
                                                    قاعدي</b></div>
                                        </td>
                                        <td colspan="3" style="width: 25%;">
                                            <div style="text-align: center;"><b>خبرة
                                                    مهنية</b></div>
                                        </td>
                                        <td colspan="2" style="text-align: center;font-size: 15px;">
                                            <b style="top: 0;">مستحق من
                                                {{ $rappel->DATDEB }}
                                                إلى
                                                {{ $rappel->DATFIN }}
                                                أي

                                                {{ $rappel->NBRJ }}

                                                / غ

                                                {{ $rappel->JRABS }}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">الحالة</td>
                                        <td style="text-align: center">
                                            فصل/صنف
                                        </td>

                                        <td style="text-align: center">درجة</td>
                                        <td style="text-align: center">
                                            صنف/فصل
                                        </td>

                                        <td style="text-align: center">درجة</td>
                                        <td style="text-align: center">رقم</td>
                                        <td style="text-align: center">ح.العائلية</td>
                                        <td style="text-align: center">الرتبة</td>

                                    </tr>
                                    <tr>
                                        <td>الجديدة</td>
                                        <td style="text-align: center">{{ $rappel->new_rappel_rasit->CATEG ?? '/' }}
                                        </td>

                                        <td style="text-align: center">

                                            <!----><span>{{ $rappel->new_rappel_rasit->ECH ?? '/' }}</span>

                                        </td>
                                        <td style="text-align: center">
                                            {{ $rappel->new_rappel_rasit->CATEG ?? '/' }}
                                        </td>

                                        <td style="text-align: center">
                                            <!----><span>{{ $rappel->new_rappel_rasit->ECH ?? '/' }}</span>
                                        </td>
                                        <td style="text-align: center">
                                            <!---->
                                        </td>
                                        <td style="text-align: center">
                                            <!----><span> {{ $rappel->new_rappel_rasit->SITFAM ?? '/' }}
                                            </span>
                                        </td>
                                        <td>
                                            <!----><span>{{ $rappel->new_rappel_rasit->fonction->LIBTABA ?? '/' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>القديمة</td>
                                        <td style="text-align: center">{{ $rappel->old_rappel_rasit->CATEG ?? '/' }}
                                        </td>

                                        <td style="text-align: center">

                                            <!----><span>{{ $rappel->old_rappel_rasit->ECH ?? '/' }}</span>
                                        </td>
                                        <td style="text-align: center">
                                            {{ $rappel->old_rappel_rasit->CATEG ?? '/' }}
                                        </td>

                                        <td style="text-align: center">
                                            <!----><span>{{ $rappel->old_rappel_rasit->ECH ?? '/' }}</span>

                                        </td>
                                        <td style="text-align: center">
                                            <!---->
                                        </td>
                                        <td style="text-align: center">
                                            {{ $rappel->old_rappel_rasit->SITFAM ?? '/' }}

                                        </td>
                                        <td>
                                            {{ $rappel->old_rappel_rasit->fonction->LIBTABA ?? '/' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>

                        <td>

                            <!---->
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
        <br>
        <br>
        <br>
        @if (!empty($grants))
            <div>
                <table class="case">
                    <thead>
                        <tr>
                            <th>الرمز</th>
                            <th>المنح</th>

                            <th>الحالة الجديدة</th>
                            <th>الحالة القديمة</th>
                            <th>الفرق</th>
                            <th>الإستحقاق</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!---->
                        @foreach ($grants as $value)
                            @php
                                $isBase = in_array($value->IND, $_primes_base_inds);
                                $isFamily = in_array($value->IND, $_primes_family_inds);
                                $isRetenue = in_array($value->IND, $_retenues_inds);
                            @endphp

                            {{-- 🔵 BASE --}}
                            @if ($isBase)
                                <tr>
                                    <td><b>{{ $value->IND }}</b></td>
                                    <td><b>{{ $value->LIBINDA ?? '/' }}</b></td>
                                    <td>{{ number_format($value->MONTANT, 2) }}</td>
                                    <td>{{ number_format($value->old_montant ?? 0, 2) }}</td>
                                    <td>{{ number_format($value->MONTANT - ($value->old_montant ?? 0), 2) }}</td>
                                    <td>{{ number_format($value->due_montant ?? 0, 2) }}</td>
                                </tr>

                                {{-- 🟢 FAMILY --}}
                            @elseif ($isFamily)
                                <tr>
                                    <td><b>{{ $value->IND }}</b></td>
                                    <td><b>{{ $value->LIBINDA ?? '/' }}</b></td>
                                    <td>{{ number_format($value->MONTANT, 2) }}</td>
                                    <td>{{ number_format($value->old_montant ?? 0, 2) }}</td>
                                    <td>{{ number_format($value->MONTANT - ($value->old_montant ?? 0), 2) }}</td>
                                    <td>{{ number_format($value->due_montant ?? 0, 2) }}</td>
                                </tr>

                                {{-- 🟡 OTHER --}}
                            @elseif (!$isBase && !$isFamily && !$isRetenue)
                                <tr>
                                    <td><b>{{ $value->IND }}</b></td>
                                    <td><b>{{ $value->LIBINDA ?? '/' }}</b></td>
                                    <td>{{ number_format($value->MONTANT, 2) }}</td>
                                    <td>{{ number_format($value->old_montant ?? 0, 2) }}</td>
                                    <td>{{ number_format($value->MONTANT - ($value->old_montant ?? 0), 2) }}</td>
                                    <td>{{ number_format($value->due_montant ?? 0, 2) }}</td>
                                </tr>

                                {{-- 🔴 RETENUES --}}
                            @elseif ($isRetenue)
                                {{-- 610 --}}
                                @if ($value->IND == 610)
                                    <tr>
                                        <td><b>{{ $value->IND }}</b></td>
                                        <td><b>المبلغ الخام</b></td>
                                        <td><b>{{ number_format($value->BASENBR, 2) }}</b></td>
                                        <td><b>{{ number_format($value->old_basenbr ?? 0, 2) }}</b></td>
                                        <td><b>{{ number_format($value->BASENBR - ($value->old_basenbr ?? 0), 2) }}</b>
                                        </td>
                                        <td><b>{{ number_format($value->due_basenbr ?? 0, 2) }}</b></td>
                                    </tr>

                                    {{-- 999 --}}
                                @elseif ($value->IND == 999)
                                    <tr>
                                        <td><b>{{ $value->IND }}</b></td>
                                        <td><b>{{ $value->LIBINDA ?? '/' }}</b></td>
                                        <td><b>{{ number_format($value->MONTANT, 2) }}</b></td>
                                        <td><b>{{ number_format($value->old_montant ?? 0, 2) }}</b></td>
                                        <td><b>{{ number_format($value->MONTANT - ($value->old_montant ?? 0), 2) }}</b>
                                        </td>
                                        <td><b>{{ number_format($value->due_montant ?? 0, 2) }}</b></td>
                                    </tr>

                                    {{-- باقي retenues --}}
                                @else
                                    <tr>
                                        <td><b>{{ $value->IND }}</b></td>
                                        <td><b>{{ $value->LIBINDA ?? '/' }}</b></td>
                                        <td>{{ number_format($value->MONTANT, 2) }}</td>
                                        <td>{{ number_format($value->old_montant ?? 0, 2) }}</td>
                                        <td>{{ number_format($value->MONTANT - ($value->old_montant ?? 0), 2) }}</td>
                                        <td>{{ number_format($value->due_montant ?? 0, 2) }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <br>
        <!---->

        <div id="piece5" style="    margin-top: 50px;">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div>رمز المخلف :{{ $rappel->ra_megration->LOT ?? ' ' }}</div>

                            <div><strong>ملاحظة هامة</strong></div>
                            تسلم نسخة للمعني وتوضع أخرى في الملف
                        </td>
                        <td style="width: 40%"></td>
                        <td style="width: 140px">
                            <span style="float: right">التاريخ:</span>
                            <ats-text _nghost-c11="">
                                <div _ngcontent-c11="" style="width: 100%;    text-align: center">


                                    <!----><span _ngcontent-c11="" class="ats-text-span"> {{ date('Y/m/d') }}
                                        <i _ngcontent-c11="" class="edit-btn for-scrren fa fa-edit"></i>
                                    </span>
                                    <!---->
                                </div>
                            </ats-text><br>
                            <!----><span> الإمضاء</span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!---->
    </div>

</div>
