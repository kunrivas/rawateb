@extends('layouts.admin')
@section('title')
    تسير حجز المخلفات
@endsection
@section('content-title')
    <h1> تسير حجز المخلفات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin-rappels') }}">تسير المخلفات </a></li>
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
            <a class="btn btn-success " href="{{ route('admin-rappel-create') }}">إضافة مخلف جديد</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">السنة</th>
                        <th scope="col">العنوان</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rappelReservations as $rappelReservation)
                        <tr>


                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $rappelReservation->YEAR }}
                            </td>
                            <td>
                                {{ $rappelReservation->TITLE }}
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
                                            href="{{ route('admin-rappels-establishments', $rappelReservation->rappel_reservation_id) }}">معاينة</a>
                                       <form action="{{ route('admin-rappel-status') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ $rappelReservation->rappel_reservation_id }}">
                                            <input type="hidden" name="sitpai"
                                                value="@if ($rappelReservation->STATUS==1) 0 @else 1 @endif">
                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                @if ($rappelReservation->STATUS==1)
                                                    غلق
                                                @else
                                                    فتح
                                                @endif
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
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
