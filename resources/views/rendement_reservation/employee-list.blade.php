@extends('layouts.index')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    <h1> حجز المردودية </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }

        tr.saved {
            background: #00800030;
        }

        tr.new {
            background: #ff000036;
        }

        tr.saved-0 {
            background: #ffa50040;
        }

        tr.new td,
        tr.saved td {
            background: transparent;
        }
    </style>
@endsection

@section('contents')

    {{--
        form for search and filtrage
     --}}
    <form method="post" action="{{ route('rendements-reservation-employee-list', $rendementReservation->id) }}">
        @csrf
        <div class="col-6 input-group mb-3 row">
            {{--  label search --}}
            <div class="col-2  text-center">إبحث عن</div>

            <div class="col-8" style="position: relative">
                {{--  input search --}}
                <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                    value="{{ $search }}">
                {{-- dropdown filter --}}
                <div class="dropdown" style="position: absolute;top:0;left:9px">
                    {{--  btn of  open filter  dropdown --}}
                    <button class="btn  " type="button" data-toggle="dropdown"
                        style="background: transparent; height: 34px;          border-right: 1px solid #ced4da;
                          ">
                        {{-- btn icon --}}
                        <i class="fa fa-filter"></i>
                    </button>
                    {{--   menu of dropdown --}}
                    <div class="dropdown-menu dropdown-menu-right  "
                        style="width: 300px;padding: 10px;     border: 1px solid gray;
                    ">
                        <div class="row">

                            {{--   the part  of adms  --}}
                            <div class="col" style="border-right: 0.5px solid #dfd9d9;padding-right: 10px;">
                                <h5 style="text-align: right">الادارة</h5>
                                <div>
                                    @foreach ($adms as $adm)
                                        {{--   condition if to ignor  'الكل' --}}
                                        @if ($adm->ADM != '0')
                                            <div class="form-check d-flex">
                                                <input class="form-check-input" type="checkbox"
                                                    name="adms[{{ $adm->ADM }}]" {{-- condition if this adm->ADM is in select_adms array make it checked --}}
                                                    @if (in_array($adm->ADM, $select_adms)) checked @endif
                                                    id="flexCheckIndeterminate">
                                                {{-- checkbox label of affichage --}}
                                                <label class="form-check-label" for="flexCheckIndeterminate">
                                                    {{ $adm->LIBTABA }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            {{--   the part  of status  --}}

                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
        </div>
    </form>

    {{--  verify condition (if) status of rendementReservation and  rendement_reservations_statistic ==0
            to togle (show and hide) the form  buttons of opperations  --}}

    <div class="row">
        <div class="col">
            @csrf
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col"> المؤسسة الحجز </th>
                        <th scope="col"> عدد ايام الغياب </th>
                        <th scope="col">نقطة المردودية </th>

                    </tr>
                </thead>
                <tbody>
                    {{--  verify condition (if) rendement_reservations_employees is not empty
                       to togle (show and hide) buttons of opperations  --}}
                    @if (!empty($rendement_reservations_employees) && $rendement_reservations_employees->count())
                        @foreach ($rendement_reservations_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->establishment->estab_ar_name ??""}}</td>

                                <td>{{ $value->abs }}
                                </td>
                                <td>

                                    {{ $value->point }} / {{ intval($value->employee->fonction->TAUXPR ?? '') }}
                                </td>


                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="10">لم يت حجز اي موضف لحد الان</td>

                        </tr>
                    @endif
                </tbody>

            </table>

        </div>
    </div>
    {{--  verify condition (if) status of rendementReservation and  rendement_reservations_statistic ==0
                                    to togle (show and hide) end of form    --}}

@endsection
@section('js')
@endsection
