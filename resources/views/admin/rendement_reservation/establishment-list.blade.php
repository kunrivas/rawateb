@extends('layouts.admin')
@section('title')
    تسير حجز المردودية
@endsection
@section('content-title')
    <h1> تسير حجز المردودية</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير حجز المردودية</a></li>
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
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع.م التي انهت الحجز</span>

                    <span class="info-box-number">{{ $statistic['done'] }}</span>
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

                    <span
                        class="info-box-number">{{ $statistic['total'] - $statistic['done'] - $statistic['start'] }}</span>
                </div>

            </div>

        </div>

    </div>

    <div class="row mb-1">
        <div class="col">

            <form method="post" class="row"
                action="{{ route('admin-rendements-establishments', $rendementReservation->id) }}">
                @csrf
                <div class=" input-group mb-3 row">
                    {{--  label search --}}
                    <div class="col-2  text-center">إبحث عن</div>

                    <div class="col-8" style="position: relative">
                        {{--  input search --}}
                        <input type="text" class="form-control" id="search" name="search" placeholder="مؤسسة"
                            value="{{ $search }}">
                        {{-- dropdown filter --}}

                    </div>

                    <button class="btn btn-info col-2 btn-sm" type="submit" id="button">إبحث</button>
                </div>
            </form>
        </div>
        <div class="col d-flex justify-content-end">
            <a class="btn btn-danger btn-sm text-white mx-2 " style="    height: fit-content;            "
                href="{{ route('admin-rendements-in-establishments', $rendementReservation->id) }}">قائمة المؤسسات التي لم
                تحجز
            </a>
             <a class="btn btn-danger btn-sm text-white mx-2 " style="    height: fit-content;            "
                href="{{ route('admin-rendements-not-reserved', $rendementReservation->id) }}">قائمة الموظفين التي لم
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
                        <th scope="col">عدد الموظفين</th>
                        <th scope="col">عدد الذين تم حجزهم</th>
                        <th scope="col">عدد الذين لدهم نقطة 0</th>
                        <th scope="col">عدد الذين لم يحجزوا</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rendementReservationsStatistics as $rendementReservationsStatistic)

                        <tr>


                            <td>
                                {{ $rendementReservationsStatistic->estab_rawateb_user }}
                            </td>
                            <td>
                                {{ $rendementReservationsStatistic->estab_ar_name }}
                            </td>
                            <td>

                                @if ($rendementReservationsStatistic->status)
                                    <span class="badge badge-success p-2">تم الحجز</span>
                                @else
                                    <span class="badge badge-warning p-2">يحجز</span>
                                @endif
                            </td>
                            <td>
                                {{ $rendementReservationsStatistic->total }}
                            </td>
                            <td>
                                {{ $rendementReservationsStatistic->reserved }}
                            </td>
                            <td>
                                {{ $rendementReservationsStatistic->ziroPoint }}
                            </td>
                            <td>
                                {{ $rendementReservationsStatistic->total - $rendementReservationsStatistic->reserved }}
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
                                            href="{{ route('admin-rendements-establishments-employees', $rendementReservationsStatistic->id) }}">معاينة</a>
                                        @if ($rendementReservationsStatistic->status)
                                            <form action="{{ route('admin-rendements-establishments-open') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ $rendementReservationsStatistic->id }}">
                                                <button type="submit" class="dropdown-item font-weight-bold "
                                                    href="#">
                                                    فتح
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </td>

                        </tr>

                    @endforeach


                </tbody>
            </table>
            {{ $rendementReservationsStatistics->appends(request()->input())->links() }}

        </div>
    </div>
@endsection
@section('js')
    <script defer>
        $(".run").click(function(evt) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            megration = $(this).attr("megration");
            data = [];
            data["ID_MEGRATION"] = megration;
            data["_token"] = _token;
            console.log(data);

            $.ajax({
                type: 'POST',
                url: "{{ route('admin-megration-salary-run') }}",
                data: {
                    ID_MEGRATION: megration,
                    _token: _token
                },
            });
            $(this).attr('disabled', 'disabled');
            setTimeout(() => {
                location.reload();
            }, 5000);

        });
    </script>
@endsection
