@extends('layouts.index')
@section('title')
    كشف الراتب الفردي
@endsection
@section('content-title')
    <h1> كشف راتب فردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف راتب</a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
    <li class="breadcrumb-item"><a href="#">شهري</a></li>
@endsection


@section('contents')
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1" scope="col">#</th>
                        <th class="col-md-2" scope="col">السنة</th>
                        <th class="col-md-9" scope="col">الشهر</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($salary_single_years as $year => $salary_singles)
                        <tr onclick="toggale_months({{ $year }})" state="0" id="year-{{ $year }}">
                            <td class="    td-1 months-title show-hidden">
                                <span class="show-hidden" style="display: none" id="months-down-{{ $year }}"
                                    onclick="hidden_months({{ $year }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </span>
                                <span class=" show-hidden" id="months-left-{{ $year }}"
                                    onclick="show_months({{ $year }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                                    </svg>
                                </span>
                            </td>
                            <td class="td-1 months-title show-hidden "
                                style=" font-size: 20px !important;font-weight: bold;">{{ $year }}
                            </td>
                            <td class="td-80">
                                <div class="responsive v-responsive months" id="months-{{ $year }}">
                                    <table class="table  table-responsive table-bill-global ">

                                        <tbody>

                                            @if (!empty($salary_singles))
                                                @foreach ($salary_singles as $month => $salary_single)
                                                    <tr>

                                                        <td class="td-1 months-title "
                                                            style=" font-size: 20px !important;font-weight: bold;">
                                                            {{ Mlibrary::getArabicMonth($salary_single->megration->MONTH) }}
                                                        </td>
                                                        <td class="td-30">
                                                            <form action="{{ route('salary-single-print') }}"
                                                                method="post" target="_blank">

                                                                {{-- using csrf is obligatoire in post method --}}
                                                                @csrf

                                                                {{-- input type ="hidden" to send parametres with post methode --}}
                                                                <input type="hidden" name="MATRI"
                                                                    value="{{ $employee->MATRI }}">
                                                                <input type="hidden" name="ID_MEGRATION"
                                                                    value="{{ $salary_single->ID_MEGRATION }}">
                                                                <input type="hidden" name="ADM"
                                                                    value="{{ $salary_single->ADM }}">

                                                                {{-- add new parametre (lang) to send with post method
                                                            and affect to her 2 vlaues in chaque submit btns --}}
                                                                <button type="submit" name="lang" value="ar"
                                                                    class="btn text-white btn-primary">عربي</button>
                                                                <button type="submit" name="lang" value="fr"
                                                                    class="btn text-white btn-success">فرنسي</button>

                                                            </form>
                                                        </td>
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
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <style>
        .v-responsive {
            background: white;
        }

        .v-responsive table,
        .v-responsive tr {
            width: 100%;
            text-align: center !important;
        }

        .v-responsive .td-25,
        .v-responsive .th-25 {
            width: 24.7%;
        }

        .v-responsive .td-30,
        .v-responsive .th-30 {
            width: 90.7%;
            display: flex;
            justify-content: end;
        }

        .v-responsive .td-15,
        .v-responsive .th-15 {
            width: 14.7%;
        }

        .v-responsive .td-20,
        .v-responsive .th-20 {
            width: 21.7%;
        }

        .v-responsive .td-80,
        .v-responsive .th-80 {
            width: 25.7%;

        }

        .v-responsive .td-2,
        .v-responsive .th-2 {
            width: 0.1%;

        }

        .v-responsive .td-1,
        .v-responsive .th-1 {
            width: 0.1%;

        }

        .v-btn-save {
            border: 1px solid green;
            color: green;
            padding: 3px 5px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 12px;

        }

        .headr-title {
            border: 1px solid gray;
            padding-top: 9px;

        }

        .title {
            width: 80%;
            text-align: center;

        }

        .show-hidden {
            cursor: pointer;
        }

        .months-title {
            vertical-align: middle !important;
        }

        .months {
            display: none;
            vertical-align: middle
        }
    </style>
    <script>
        function show_months(year) {
            $("#months-" + year).css({
                'display': 'block'
            });
            $("#months-down-" + year).css({
                'display': 'block'
            });

            $("#months-left-" + year).css({
                'display': 'none'
            });


        }

        function hidden_months(year) {
            $("#months-" + year).css({
                'display': 'none'
            });
            $("#months-down-" + year).css({
                'display': 'none'
            });

            $("#months-left-" + year).css({
                'display': 'block'
            });
        }



        function toggale_months(year) {
            state = $("#year-" + year).attr("state");
            if (state == 0) {
                $("#year-" + year).attr("state", 1);
                show_months(year);
            } else {
                $("#year-" + year).attr("state", 0);
                hidden_months(year);

            }


        }
    </script>
@endsection
