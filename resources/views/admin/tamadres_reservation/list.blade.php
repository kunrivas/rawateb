@extends('layouts.admin')
@section('title')
    تسير حجز التمدرس
@endsection
@section('content-title')
    <h1> تسير حجز التمدرس </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin-tamadres') }}">تسير التمدرس </a></li>
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
            <a class="btn btn-success " href={{ route('admin-tamadres-create') }}>إضافة منحة تمدرس جديدة</a>
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
                    @foreach ($tamadresReservations as $tamadresReservation)
                        <tr>


                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $tamadresReservation->YEAR }}
                            </td>
                            <td>
                                {{ $tamadresReservation->TITLE }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm">العمليات</button>
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        {{-- the btn of معاينة --}}
                                        <a class="dropdown-item font-weight-bold" href={{route('admin-tamadres-establishments',$tamadresReservation->tamadres_reservation_id)}}>معاينة</a>
                                        {{-- the btn of status غلق وفتح --}}
                                        <form action={{ route('admin-tamadres-status') }} method="post">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ $tamadresReservation->tamadres_reservation_id }}">
                                            {{--   change the value of sent status between 0 and 1  --}}
                                            <input type="hidden" name="status"
                                                value="@if ($tamadresReservation->STATUS == 1) 0 @else 1 @endif">
                                            {{--  change the value of label of btn between غلق and فتح --}}
                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                @if ($tamadresReservation->STATUS == 1)
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
