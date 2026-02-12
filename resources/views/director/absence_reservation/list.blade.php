@extends('layouts.director')
@section('title')
    حجز الغيابات
@endsection
@section('content-title')
    <h1> حجز الغيابات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز الغيابات </a></li>
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

@section('contents')
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
                    @foreach ($dir_absence_reservations as $absence_reservation)
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
                            <td>
                                <a  href={{ route('director-absence-reservation-employees-list', $absence_reservation->dir_absence_reservation_id) }}
                                    class="btn btn-primary">
                                    معاينة
                                </a>

                                <a   href={{ route('director-absence-reservation-print', $absence_reservation->dir_absence_reservation_id) }}
                                    target="_blank"  class="btn btn-success">
                                    طباعة
                                </a>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>

@endsection
