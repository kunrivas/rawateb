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

</style>

<body>
    <div align="center">
        <table style="width:920px;" class="font16">
            <tr>
                <td colspan="4" class="aligncenter font24 "> République algérienne démocratique et populaire </td>
            </tr>
            <tr>
                <td colspan="4" class="aligncenter font24"> Ministère de l'Education Nationale</td>
            </tr>
            <tr>
                <td colspan="3" class="font16"> Direction de l'Éducation de l'Etat d'El Oued</td>
                <td>Déclaration de salaire de l'année 
                    {{ $salary_single->megration->YEAR }}</td>
            </tr>
            <tr>
                <td> <span> l'établissement: </span><span>{{-- @if (is_null($serv)) / @else {{ $serv->estab_ar_name }} @endif --}}</span></td>
            </tr>
            <tr>
                <td> <span>code de l'établissement :</span> <span>@if (is_null(session()->get("establishment"))) /@else{{ session()->get("establishment")->estab_rawateb_user }}  @endif </span> </td>
            </tr>
            <tr>
                <td colspan="3" class="info"><span> Le code :</span> <span> {{ $employee->MATRI }}</span> </td>
                <td class="info"><span>numéro d'assurance:</span> <span> {{ $employee->NUMSS }}</span></td>
            </tr>
            <tr>
                <td class="info" colspan="3"><span>Nom :</span> <span> {{ $employee->NOM }}</span></td>
                <td class="info"><span>fonction :</span><span>
                        @if (is_null($salary_single->fonction)) / ({{ $salary_single->ADM }}) @else {{ $salary_single->fonction->LIBTAB }} ({{ $salary_single->ADM }}) @endif</span></td>
            </tr>
            <tr>
                <td class="info" colspan="3"><span>prenom :</span> <span> {{ $employee->PRENOM }}</span></td>
                <td class="info"><span>catégorie : </span><span>{{ $salary_single->CATEG }}</span>
                    <span>echelon : </span><span>{{ $salary_single->ECH }}</span>
                </td>
            </tr>
            <tr>
                <td class="info" colspan="3"> <span>Situation familiale :</span>
                    <span>{{ $salary_single->SITFAM }}</span>
                </td>
                <td class="info"><span>compte : </span><span>{{ $salary_single->CLECPT }}</span>
                    <span>/</span><span>{{ $salary_single->NUMCPT }}</span>
                </td>
            </tr>
            <tr class="info-last">
                <td class="info" colspan="3"> <span>Date de travail:</span>
                    <span>{{ Mlibrary::getDateFormat($employee->DATENT) }}</span>
                </td>
                <td class="info" colspan="3"> <span>Lieu de travail :</span>
                    <span>{{ $salary_single->AFFECT }}</span>
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
                                <th colspan="2" >Éléments de salaire</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($salary_grants['primes']['base'] as $key => $value)
                                <tr>
                                    <td><b> {{ $value->grant_info->LIBIND }}</b></td>
                                    <td><b> {{ number_format($value->MONTANT*12, 2) }}</b> </td>
                                </tr>
                            @endforeach
                            @foreach ($salary_grants['primes']['other'] as $key => $value)
                                <tr>
                                    <td> {{ $value->grant_info->LIBIND }}</td>
                                    <td> {{ number_format($value->MONTANT*12, 2) }} </td>
                                </tr>
                            @endforeach
                            @foreach ($salary_grants['primes']['family'] as $key => $value)
                                <tr>
                                    <td> {{ $value->grant_info->LIBIND }}</td>
                                    <td> {{ number_format($value->MONTANT *12, 2) }} </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>MONTANT*12 brut total </td>
                                <td > {{ number_format($salary_single->TOTGAIN *12, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="2" align="left" class="view">
                    <table class="case">
                        <thead>
                            <tr>
                                <th colspan="2" > Déductions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (array_key_exists(610, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][610]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][610]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @if (array_key_exists(980, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][980]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][980]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @if (array_key_exists(660, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][660]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][660]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @if (array_key_exists(399, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][399]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][399]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @if (array_key_exists(397, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][397]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][397]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @if (array_key_exists(398, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td>{{ $salary_grants['retenues']['inds'][398]->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($salary_grants['retenues']['inds'][398]->MONTANT*12, 2) }}
                                    </td>
                                </tr>
                            @endif
                            @foreach ($salary_grants['retenues']['other'] as $key => $value)
                                <tr>
                                    <td>{{ $value->grant_info->LIBIND }}</td>
                                    <td>{{ number_format($value->MONTANT*12, 2) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td>Le nombre de jours de travail</td>
                                <td>{{ $salary_single->NBRTRAV }}</td>
                            </tr>
                            @if (array_key_exists(999, $salary_grants['retenues']['inds']))
                                <tr>
                                    <td >{{ $salary_grants['retenues']['inds'][999]->grant_info->LIBIND }}</td>
                                    <td >
                                        {{ number_format($salary_grants['retenues']['inds'][999]->MONTANT*12, 2) }}
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
                <td dir="rtl">El oued en : {{ date('Y/m/d') }} &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
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
                <td dir="rtl" colspan="1">Signature &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
            </tr>

        </table>
    </div>
</body>

</html>
