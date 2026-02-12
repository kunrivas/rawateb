@extends('layouts.admin')
@section('title')
    تسير حجز منح التمدرس
@endsection
@section('content-title')
    <h1> تسير حجز منح التمدرس</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز منح التمدرس </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير حجز التمدرس</a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }
    </style>
@endsection

@section('contents')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد المؤسسات</span>
                    <span class="info-box-number">{{ $statistic['total'] }}</span>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع.م التي انطلقت في الحجز </span>
                    <span class="info-box-number">{{ $statistic['start'] }}</span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع.م التي لم تنطلق في الحجز</span>

                    <span class="info-box-number">{{ $statistic['total'] - $statistic['start'] }}</span>
                </div>

            </div>

        </div>

    </div>

    <div class="row mb-1">
        <div class="col">

            <form method="post" class="row"
                action="{{ route('admin-tamadres-establishments', $tamadres_reservation->tamadres_reservation_id) }}">
                @csrf
                <div class=" input-group mb-3 row">
                    {{--  label search --}}
                    <div class="col-2  text-center">إبحث عن</div>

                    <div class="col-8" style="position: relative">
                        {{--  input search --}}
                        <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                            value="{{ $search }}">
                        {{-- dropdown filter --}}

                    </div>

                    <button class="btn btn-info col-2 btn-sm" type="submit" id="button">إبحث</button>
                </div>
            </form>

        </div>
         <div class="col d-flex justify-content-end">
            <a class="btn btn-danger btn-sm text-white mx-2 " style="    height: fit-content;            "
                href="{{ route('admin-tamadres-in-establishments', $tamadres_reservation->tamadres_reservation_id) }}">قائمة المؤسسات التي لم
                تحجز
            </a>
        </div>
 
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الرمز</th>
                        <th scope="col">إسم المؤسسة</th>
                        <th scope="col"> الحالة</th>
                        <th scope="col">عدد الذين تم حجزهم</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tamadres_reservationsStatistics as $tamadres_reservationsStatistic)
                        @if ($tamadres_reservationsStatistic->establishment)
                            <tr>


                                <td>
                                    {{ $tamadres_reservationsStatistic->establishment->estab_rawateb_user }}
                                </td>
                                <td>
                                    {{ $tamadres_reservationsStatistic->establishment->estab_ar_name }}
                                </td>
                                <td>

                                    @if ($tamadres_reservationsStatistic->STATUS)
                                        <span class="badge badge-success p-2">تم الحجز</span>
                                    @else
                                        <span class="badge badge-warning p-2">يحجز</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $tamadres_reservationsStatistic->RESERVED }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-success btn-sm">العمليات</button>
                                        <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only"> </span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item font-weight-bold"
                                                href="{{ route('admin-tamadres-establishments-employees', $tamadres_reservationsStatistic->id) }}">معاينة</a>

                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endif
                    @endforeach


                </tbody>
            </table>
            {{ $tamadres_reservationsStatistics->appends(request()->input())->links() }} 

        </div>
    </div>
@endsection
@section('js')

@endsection
