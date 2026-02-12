@extends('layouts.admin')
@section('title')
    تسير حجز الغيابات
@endsection
@section('content-title')
    <h1> تسير حجز الغيابات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dir-admin-absence') }}">تسير الغيابات </a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }
    </style>
@endsection

@section('contents')
    <div class="row mb-2">
        <div class="col"></div>
        <div class="col-2">
            <a class="btn btn-success " href="{{ route('dir-admin-absence-create') }}">إضافة شهر جديد</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">السنة</th>
                        <th scope="col">الشهر</th>
                        <th scope="col">النوع</th>
                        <th scope="col">مفتوح / مغلق</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absence_reservations as $absence_reservation)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $absence_reservation->YEAR }}
                            </td>
                            <td>
                                {{ Mlibrary::getArabicMonth($absence_reservation->MONTH) }}
                            </td>
                            <td>
                                @if ($absence_reservation->Type == 0)
                                    <span class="badge badge-primary p-2">غياب</span>
                                @else
                                    <span class="badge badge-secondary p-2">إضراب </span>
                                @endif

                            </td>
                            <td>
                                @if ($absence_reservation->STATUS)
                                    <span class="badge badge-success p-2"> مفتوح</span>
                                @else
                                    <span class="badge badge-danger p-2">مغلق </span>
                                @endif

                            </td>
                            <td style="display: flex;justify-content: center;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm">العمليات</button>
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        {{-- btn of "معاينة" --}}
                                        <a class="dropdown-item font-weight-bold"
                                            href="{{ route('dir-admin-absence-employees-list', $absence_reservation->dir_absence_reservation_id) }} ">معاينة</a>
                                        {{-- btn of "طباعة" --}}
                                        <a class="dropdown-item font-weight-bold"
                                            href="{{ route('dir-admin-absence-print', $absence_reservation->dir_absence_reservation_id) }} ">طباعة</a>

                                        {{-- btn of "فتح/غلق" --}}
                                        <form action=" {{ route('dir-admin-absence-status') }} " method="post">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ $absence_reservation->dir_absence_reservation_id }}">
                                            {{-- condition if status to modify value of input hidden --}}
                                            <input type="hidden" name="status"
                                                value="@if ($absence_reservation->STATUS) 0 @else 1 @endif">
                                            {{-- condition if status to modify the btn --}}
                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                @if ($absence_reservation->STATUS)
                                                    غلق
                                                @else
                                                    فتح
                                                @endif
                                            </button>
                                        </form>
                                        {{-- btn of "export" --}}

                                        {{--   <form action="{{ route('admin-rendements-export') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $absence_reservation->id }}">

                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                تصدير
                                            </button>
                                        </form> --}}

                                        {{-- btn of "delete"
                                        <form action="{{ route('dir-admin-absence-delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ $absence_reservation->dir_absence_reservation_id }}">
                                            <button type="submit" class="dropdown-item text-danger font-weight-bold"
                                                href="#">حذف</button>
                                        </form> --}}
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn  btn-success btn-sm">تصدير EXCEL</button>
                                    <button type="button" class="btn btn-success btn-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu  dropdown-menu-bottom" role="menu" style="">
                                        @foreach ($adms as $adm)
                                            @if ($adm->ADM != '0')
                                                <form class="dropdown-item" style="padding: 0;" target="_black"
                                                    action="{{ route('dir-admin-absence-export-excel') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="dir_absence_reservation_id"
                                                        value="{{ $absence_reservation->dir_absence_reservation_id }}">
                                                    <input type="hidden" name="ADM" value="{{ $adm->ADM }}">
                                                    <input class="btn-list" type="submit" value="{{ $adm->LIBTABA }}"
                                                        style="    width: 100%; background: transparent; border: none; border-bottom: 1px solid gray;" />



                                                </form>
                                            @endif
                                        @endforeach

                                    </div>

                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $absence_reservations->links() }}
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
@section('css')
    <style>
        .btn-list {
            font-size: 11px;
            border: none;
            width: 100%;
            height: 100%;
            background: white;
            text-align: justify;
            cursor: pointer;
            padding: 0;
            padding: 0.25rem 1rem;

        }

        .btn-list:hover {
            background: #a2adba5c;
        }

        .dropdown-menu-bottom {
            /* top: auto !important;*/
            bottom: 0 !important;
            margin-bottom: 0.125rem;
            /* Adjust as needed */
        }

        .dropdown-item {
            background: white;
        }
    </style>
@endsection
