@extends('layouts.index')
@section('title')
    حجز المخلفات
@endsection
@section('content-title')
    <h1> حجز المخلفات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المخلفات </a></li>
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
                        <th scope="col">العنوان</th>
                        <th scope="col">العمليات</th>
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
                                {{ $rappelReservation->TYTLE }}
                            </td>
                            <td>
                                <a href=" {{ route('rappel-reservation-employees-list', $rappelReservation->rappel_reservation_id) }}"
                                    class="btn btn-primary">
                                    معاينة
                                </a>

                                <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal"
                                    data-target="#infoModal">
                                    طباعة</button>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade " id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content " style="width: 650px">
                <form action="{{ route("rappel-reservation-print") }}" target="_blank" method="post">
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
                            value="{{ $rappelReservation->rappel_reservation_id }}">
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <label for="establishmentCode">رقم الهاتف</label>
                                    <input  class="form-control" type="text" name="phone"  required>

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
