<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>منحة التمدرس</title>
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
        line-height: 40px
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
        line-height: 40px
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
    @if ($tamadresDatas->count())

        @foreach ($tamadresDatas as $adm => $data)
            <div align="center">
                <table style="width:920px;" class="font16">
                    <tr>
                        <td colspan="4" class="aligncenter font30"> الجمهورية الجزائرية الديمقراطية الشعبية </td>

                    </tr>
                    <tr>
                        <td colspan="4" class="aligncenter font30"> وزارة التربية الوطنية </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="font18"> مديرية التربية لولاية الوادي </td>
                        <td> الادارة رقم : {{ $adm }} </td>
                    </tr>
                    <tr>
                        <td colspan="3"> <span>المؤسسة: </span><span>@if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_ar_name }}  @endif</span></td>
                    </tr>
                    <tr>
                        <td> <span>رمز المؤسسة</span> <span>@if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_rawateb_user }}  @endif</span> </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="aligncenter font24">
                            {{-- {{dd($data);}}  --}}

                            {{-- @foreach ($data as $key => $value) 
                      {{$value->ta_megration->TITLE }}
                      {{$value->ta_megration->YEAR }}
                      
                      {{-- @break;
                      @endforeach --}}
                            {{ $data[0]->ta_megration->TITLE }}

                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="aligncenter font24">
                            {{-- {{dd($data);}}  --}}

                            {{-- @foreach ($data as $key => $value) 
                      {{$value->ta_megration->TITLE }}
                      {{$value->ta_megration->YEAR }}
                      
                      {{-- @break;
                      @endforeach --}}
                      سنة : {{ $data[0]->ta_megration->YEAR }}
  
                        </td>
                    </tr>
                    
                </table>
                <table class="case">
                    <thead>
                        <tr class="">
                            <td bgcolor="PaleGoldenrod">#</td>
                            <td bgcolor="PaleGoldenrod">الرمز</td>
                            <td bgcolor="PaleGoldenrod">الاسم واللقب </td>
                            <td bgcolor="PaleGoldenrod">الوظيفة</td>
                            <td bgcolor="PaleGoldenrod">الصنف </td>
                            <td bgcolor="PaleGoldenrod">الدرجة </td>
                            <td bgcolor="PaleGoldenrod">الحالة العائلية </td>
                            <td bgcolor="PaleGoldenrod">عدد المتمدرسين </td>
                            <td bgcolor="PaleGoldenrod"> الملاحظة</td>

                        </tr>

                    </thead>
                    <tbody>

                        @if (!empty($data))
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td style="width: 5%;">{{ $key + 1 }}</td>
                                    <td style="width: 12%;">{{ $value->MATRI }}</td>
                                    <td style="width: 20%;">{{ $value->NOMA }} {{ $value->PRENOMA }}</td>
                                    <td style="width: 21%;">{{ $value->fonction->LIBTABA ?? '/' }}</td>
                                    <td style="width: 5%;">{{ $value->CATEG }}</td>
                                    <td style="width: 5%;">{{ $value->ECH }}</td>
                                    <td style="width: 4%;">{{ $value->SITFAM }}</td>
                                    <td style="width: 4%;">{{ $value->NUMBERCHILD }}</td>
                                    <td style="width: 12%;">{{ $value->NOTES ?? '/' }}</td>
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
            @if ($tamadresDatas->last() != $tamadresDatas[$adm])
                <pagebreak />
            @endif
        @endforeach
    @else
        <table style="width:920px;" class="font16">
            <tr>
                <td>لا يملك منحة </td>
            </tr>
        </table>
    @endif
</body>

</html>
