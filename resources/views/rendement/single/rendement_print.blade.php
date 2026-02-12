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
        <td colspan="12" class="aligncenter font24"> الجمهورية الجزائرية الديمقراطية الشعبية </td>

    </tr>
    <tr>
        <td colspan="12" class="aligncenter font24"> وزارة التربية الوطنية </td>
    </tr>
    <tr>
        <td colspan="12" class="font16"> مديرية التربية لولاية الوادي </td>
    </tr>
    <tr>
        <td colspan="11"> <span>المؤسسة: </span><span> @if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_ar_name }}  @endif </span></td>

    </tr>
    <tr>
        <td colspan="11"> <span>رمز المؤسسة :</span> <span>@if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_rawateb_user }} @endif</span> </td>
        <td> <span>السنة المالية :</span> <span>{{  $rend_bill->re_megration->YEAR }}</span> </td>
    </tr>
</table>

<br>
<table style="width:920px;">
    <tr>
        <td colspan="12" class="aligncenter font24">الكشف الفردي للمردودية</td>
    </tr>
    <tr>
        <td colspan="12" class="aligncenter font18">{{ Mlibrary::getRendament($rend_bill->re_megration->TRIMESTRE) }}
            {{  $rend_bill->re_megration->YEAR }}</td>
    </tr>
    <br>
    <br>
</table>
<table style="width:920px;" class="font16">
    <thead>
        <tr>
            <th style="width:60%"></th>
            <th></th>

        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="3"> <span>الرمز</span> <span>{{  $rend_bill->MATRI }}</span> </td>
            <td> <span>رقم الضمان الاجتماعي</span> <span>{{  $rend_bill->NUMSS }}</span> </td>
        </tr>
        <tr>
            <td colspan="3"> <span>اللقب:</span> <span>{{  $rend_bill->employee->NOMA }}</span> </td>
            <td> <span> </span> الوظيفة :<span>
                    @if (is_null( $rend_bill->fonction))
                        / ({{  $rend_bill->ADM }})
                    @else
                        {{  $rend_bill->fonction->LIBTABA }} ({{  $rend_bill->ADM }})
                    @endif
                </span></span> </td>
        </tr>
        <tr>
            <td colspan="3"> <span>الاسم :</span> <span>{{  $rend_bill->employee->PRENOMA }}</span> </td>
            <td> <span>الصنف : </span> <span>{{  $rend_bill->CATEG }}</span> </td>
        </tr>
        <tr>
            <td colspan="3"> الحالة العائلية :<span></span> <span>{{  $rend_bill->SITFAM }}</span> </td>
            <td> <span> الدرجة :</span> <span>{{  $rend_bill->ECH }}</span> </td>
        </tr>

        <tr>
            <td colspan="3"> تاريخ التوظيف :<span></span>
                <span>{{ Mlibrary::getDateFormat( $rend_bill->DATENT) }}</span>
            </td>
            <td> <span>مكان العمل : </span> <span>{{  $rend_bill->AFFECT }}</span> </td>
        </tr>
        <tr>
            <td colspan="3">النقطة :<span></span> <span>{{ substr( $rend_bill->TAUX, 0, 2) }}</span> </td>
            <td> <span>أيام العمل :</span> <span>{{ substr( $rend_bill->JRPRIME, 0, 2) }}</span> <span>/غ</span> <span>{{ substr( $rend_bill->JRABS, 0, 2) }}</span></td>
        </tr>
    </tbody>
</table>
<br>
<br>
<div id="page2print" style="direction: rtl;">

    <!---->
    <div class="arkhat subpage">


        <div>
            <table class="case">
                <thead>
                    <tr>
                        <th>مكونات المردودية</th>
                        <th>المبلغ</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center"><b>الأجر القاعدي </b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->SALBASE, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b> الخبرة المهنية</b> </td>
                        <td style="text-align: center">
                            <b>{{ number_format( $rend_bill->IEPIND * 45, 2) }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>الاجر الرئيسي</b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->SALBASE +  $rend_bill->IEPIND * 45, 2) }}</b>

                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b> خام المردودية</b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->TOTGAIN, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>أقتطاع الضمان الاجتماعي</b> </td>
                        <td style="text-align: center">
                            <b>{{ number_format( $rend_bill->RETSS, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>أقتطاع الضريبة</b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->RETITS, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b>أقتطاعات اخرى</b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->MONTF ?? 0, 2) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><b> الصافي للدفع</b> </td>
                        <td style="text-align: center">
                            <b> {{ number_format( $rend_bill->NETPAI, 2) }}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <!---->

        <div id="piece5" style="    margin-top: 50px;">
            <table>
                <tbody>
                    <tr>

                        <td style="width: 75%"></td>
                        <td style="width: 140px">
                            <span style="float: right">التاريخ : {{ date('Y/m/d') }}</span>
                            <br>
                            <br>
                            <!----><span> &nbsp;&nbsp;&nbsp;&nbsp;الإمضاء&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!---->
    </div>

</div>
