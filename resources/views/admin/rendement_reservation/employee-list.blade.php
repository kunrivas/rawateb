@extends('layouts.admin')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    <h6>حجز المردودية لمؤسسة "{{ $rendement_reservations_statistic->establishment->estab_ar_name }}" </h6>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">قائمة الملؤسسات </a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin-rendements') }}">تسير المردودية </a></li>
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
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">العدد الموظفين</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->total }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين تم حجزهم</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->reserved }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد من لديهم نقطة 0</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->ziroPoint }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين لم يحجزوا</span>
                    <span
                        class="info-box-number">{{ $rendement_reservations_statistic->total - $rendement_reservations_statistic->reserved }}</span>
                </div>

            </div>

        </div>

    </div>


    <div class="row">
        <div class="col">

            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col">الإدارة </th>
                        <th scope="col"> عدد ايام الغياب </th>
                        <th scope="col">نقطة المردودية </th>
                        <th scope="col">سبب الصفر</th>


                    </tr>
                </thead>
                <tbody>

                    @if (!empty($rendement_reservations_employees) && $rendement_reservations_employees->count())
                        {{--    @foreach ($rendement_reservations_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->employee->adm->ADM ?? '' }}</td>
                                <td>{{ $value->abs }}
                                </td>
                                <td>{{ $value->point ?? '' }}
                                </td>



                            </tr>
                        @endforeach --}}

                        @foreach ($rendement_reservations_employees as $adm => $group)
                            <tr class="table-primary">
                                <th colspan="9">ADM: {{ $adm }}</th>
                            </tr>

                            @foreach ($group as $key => $value)
                                <tr
                                    @isset($value->point)
                @if ($value->point == 0)
                    class="saved-0"
                @else
                    class="saved"
                @endif
            @else
                class="new"
            @endisset>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->MATRI }}</td>
                                    <td>{{ $value->employee->NOMA }}</td>
                                    <td>{{ $value->employee->PRENOMA }}</td>
                                    <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                    <td>{{ $value->employee->adm->ADM ?? '' }}</td>
                                    <td>{{ $value->abs }}</td>
                                    <td>{{ $value->point ?? '' }}</td>
                                    <td>{{ isset($value->point) && (float) $value->point == 0 ? ($value->zero_point_reason ?? '') : '' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr>

                            <td colspan="10">There are no data.</td>

                        </tr>
                    @endif
                </tbody>

            </table>

        </div>
    </div>
    </form>

@endsection
@section('js')
    <script defer></script>
@endsection
