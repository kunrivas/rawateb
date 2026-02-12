@extends('layouts.index')
@section('title')
    حجز التمدرس
@endsection
@section('content-title')
    <h1> حجز التمدرس </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز التمدرس </a></li>
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
        <div class="col">
            {{--  table of  tamadres   --}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">العنوان</th>
                        <th scope="col">السنة</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tamadresReservations as $tamadresReservation)
                        <tr>
                            <td>
                                {{-- controur from 1  --}}
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $tamadresReservation->TITLE }}
                            </td>
                            <td>
                                {{ $tamadresReservation->YEAR }}
                            </td>
                            <td>
                                {{ $tamadresReservation->tamadres_reservation_id }}
                            </td>
                            <td>
                                <a href=" {{ route('tamadres_reservation-employees-list', $tamadresReservation->tamadres_reservation_id) }}"
                                    class="btn btn-primary">
                                    معاينة
                                </a>
                                {{--  in button print i use model to enter the phone of user --}}
                                <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal"
                                    data-target="#infoModal"    data-reservation-id="{{ $tamadresReservation->tamadres_reservation_id }}">
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
                <form action="{{ route('tamadres-reservation-print') }}" target="_blank" method="post">
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
                        {{-- input hidden to send the tamadres reservation id --}}
                        <input type="hidden" name="tamadres_reservation_id" id="tamadres_reservation_id" value="">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="establishmentCode">رقم الهاتف</label>
                                    {{--  input to enter the numero phone of user --}}
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
{{--script to pass the shoosen btn 'طباعة' -> tamadres_reservation_id to modal phone  --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var buttons = document.querySelectorAll('.show-info-btn');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var reservationId = this.getAttribute('data-reservation-id');
               /*  the input hidden in modal */ 
                document.getElementById('tamadres_reservation_id').value = reservationId;
            });
        });
    });
</script>