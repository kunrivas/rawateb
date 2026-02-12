@extends('layouts.director')
@section('title')
    تسير حجز رقم التعريف الوطني
@endsection
@section('content-title')
    <h1> تسير حجز رقم التعريف الوطني</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز رقم التعريف الوطني </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير حجز رقم التعريف الوطني</a></li>
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
                    <span class="info-box-number">{{ $totalEstabs }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع.م التي انهت الحجز</span>

                    <span class="info-box-number">{{ $estabsEnded }}</span>
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع.الاجمالي للموظفين </span>
                    <span class="info-box-number">{{ $totalEmployees }}</span>
                </div>

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ع. الإجمالي للموظفين المحجوزين</span>

                    <span class="info-box-number">{{ $totalRegistered }}</span>
                </div>

            </div>

        </div>

    </div>

    <div class="row mb-1">
        <div class="col">


        </div>
        <div class="col d-flex justify-content-end">
            <a class="btn btn-success btn-sm text-white mx-2" style="height: fit-content;"
                href="{{ route('director-tresor-excel') }}" target="_blank" rel="noopener noreferrer">
                تصدير إلى Excel
            </a>

            <a class="btn btn-danger btn-sm text-white mx-2 " style="    height: fit-content;            "
                href="{{ route('director-tresor-sql') }}">تصدير الى sql

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
                        <th scope="col">عدد الموظفين</th>
                        <th scope="col">عدد الذين تم حجزهم</th>
                        <th scope="col">عدد الذين لم يحجزوا</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats as $row)
                        <tr>
                            <td>{{ $row->AFFECT }}</td>
                            <td>{{ $row->estab_ar_name ?? 'غير معروف' }}</td>
                            <td>{{ $row->total }}</td>
                            <td class="text-success">{{ $row->nin_not_empty }}</td>
                            <td class="text-danger">{{ $row->total - $row->nin_not_empty }}</td>

                            <td>
                                <a href="{{ route('director-tresor-establishment-list', $row->AFFECT) }}"
                                    class="btn btn-info btn-sm">
                                    معاينة
                                </a>
                            </td>


                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{--   {{ $stats->appends(request()->input())->links() }}  --}}

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
                url: "{{ route('director-megration-salary-run') }}",
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
