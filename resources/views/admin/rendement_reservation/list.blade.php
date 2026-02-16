@extends('layouts.admin')
@section('title')
    تسير حجز المردودية
@endsection
@section('content-title')
    <h1> تسير حجز المردودية </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin-rendements') }}">تسير المردودية </a></li>
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
            <a class="btn btn-success " href="{{ route('admin-rendement-create') }}">إضافة ثلاثي جديد</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">الثلاثي</th>
                        <th scope="col">السنة</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rendementReservations as $rendementReservation)
                        <tr>


                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ Mlibrary::getRendament($rendementReservation->TRIMESTRE) }}
                            </td>
                            <td>
                                {{ $rendementReservation->year }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm">العمليات</button>
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        {{-- btn of "معاينة"--}}
                                        <a class="dropdown-item font-weight-bold"
                                            href="{{ route('admin-rendements-establishments', $rendementReservation->id) }}">معاينة</a>

                                            {{-- btn of "فتح/غلق"--}}
                                        <form action="{{ route('admin-rendement-status') }}" method="post">
                                            @csrf
                                          <input type="hidden" name="id" value="{{ $rendementReservation->id }}">
                                            {{-- condition if status to modify value of input hidden --}}
                                            <input type="hidden" name="sitpai"
                                                value="@if ($rendementReservation->status) 0 @else 1 @endif">
                                             {{-- condition if status to modify the btn --}}
                                           <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                @if ($rendementReservation->status)
                                                    غلق
                                                @else
                                                    فتح
                                                @endif
                                            </button>
                                        </form>
                                          {{-- btn of "export"--}}

                                        <form action="{{ route('admin-rendements-export') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $rendementReservation->id }}">

                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                تصدير
                                            </button>
                                        </form>

                                        {{-- btn of "delete"--}}
                                           <form action="{{ route('admin-rendement-delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $rendementReservation->id }}">
                                            <button type="submit" class="dropdown-item text-danger font-weight-bold"
                                                href="#">حذف</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn  btn-success btn-sm">تصدير SQL</button>
                                    <button type="button" class="btn btn-success btn-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu  dropdown-menu-bottom" role="menu" style="">
                                        @foreach ($adms as $adm)
                                            @if ($adm->ADM != '0')
                                                <form class="dropdown-item" style="padding: 0;" target="_black"
                                                    action="{{ route("admin-rendements-export-adm") }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ $rendementReservation->id }}">
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
        </div>
    </div>
@endsection
@section('js')
    <script defer>

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
