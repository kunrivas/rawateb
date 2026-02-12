@extends('layouts.admin')
@section('title')
    حجز المخلفات
@endsection
@section('content-title')
    <h6>حجز المخلفات لمؤسسة "{{ $rappel_reservations_statistic->establishment->estab_ar_name }}" </h6>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">قائمة الملؤسسات </a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin-rappels') }}">تسير المخلفات </a></li>
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
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين تم حجزهم</span>
                    <span class="info-box-number">{{ $rappel_reservations_statistic->reserved }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> م.ل منحة المنطقة</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(2) ? $rappel_reservations_employees_types[2]->count() : 0 }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل الجنوب</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(3) ? $rappel_reservations_employees_types[3]->count() : 0 }}</span>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل الدرجة</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(1) ? $rappel_reservations_employees_types[1]->count() : 0 }}</span>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل السكن</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(4) ? $rappel_reservations_employees_types[4]->count() : 0 }}</span>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل الاجر الوحيد</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(5) ? $rappel_reservations_employees_types[5]->count() : 0 }}</span>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل المنح العائلية</span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(6) ? $rappel_reservations_employees_types[6]->count() : 0 }}</span>
                </div>

            </div>

        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">م.ل أكثر من 10 سنوات </span>
                    <span
                        class="info-box-number">{{ $rappel_reservations_employees_types->has(7) ? $rappel_reservations_employees_types[7]->count() : 0 }}</span>
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
                        <th scope="col">نوع المخلف</th>
                        <th scope="col">قيمة المخلف</th>
                        <th scope="col">تاريخ السريان</th>

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($rappel_reservations_employees) && $rappel_reservations_employees->count())
                        @foreach ($rappel_reservations_employees as $key => $value)
                            <tr class="saved">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI ?? '' }}</td>
                                <td>{{ $value->employee->NOMA ?? '' }}</td>
                                <td>{{ $value->employee->PRENOMA ?? ('' ?? '') }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ Mlibrary::getRappelType($value->rappel_type) ?? '' }}</td>
                                <td>{{ $value->rappel_val ?? '' }}</td>
                                <td>{{ $value->rappel_date ?? '' }}</td>
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
    </div>
    </form>

@endsection
@section('js')
    <script defer></script>
@endsection
