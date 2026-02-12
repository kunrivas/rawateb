@extends('layouts.absence')
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
                            <td>
                                <a href={{ route('absence-reservation-employees-list', $absence_reservation->absence_reservation_id) }}
                                    class="btn btn-primary">
                                    معاينة
                                </a>

                                <a href={{ route('absence-reservation-print', $absence_reservation->absence_reservation_id) }}
                                    class="btn btn-success">
                                    طباعة
                                </a>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $absence_reservations->links() }}
        </div>
    </div>
    <div class="modal fade " id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content " style="width: 650px">
                <form action="{{ route('rappel-reservation-print') }}" target="_blank" method="post">
                    <div class="modal-header  text-center ">
                        <h5>
                            معلومات الاتصال </h5>
                        <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="rappel_reservation_id"
                            value="{{ $absence_reservation->rappel_reservation_id }}">
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="establishmentCode">رقم الهاتف</label>
                                    <input class="form-control" type="text" name="phone" required>

                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm m-1 btn-primary">طباعة</button>
                        <button type="button" class="btn btn-sm m-1 btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
