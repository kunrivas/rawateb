@extends('layouts.index')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    <h1> حجز المردودية </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }
    </style>
@endsection

@section('contents')
    {{--   affiche big note  --}}
    <div class="row">
        <div class="col">
            <div class="alert alert-danger  alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fa fa-exclamation-triangle mx-2"></i>ملاحظة هامة</h5>
                يرجى عدم ضغط على زر الطباعة النهائية إلا بعد تأكد من صحة الحجز لأنه الحجز سيغلق على مستواك
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            {{--  table of  rendement trimestres  --}}
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
                    @foreach ($rendemenReservations as $rendemenReservation)
                        <tr>
                            <td>
                                {{-- controur from 1  --}}
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ Mlibrary::getRendament($rendemenReservation->TRIMESTRE) }}
                            </td>
                            <td>
                                {{ $rendemenReservation->year }}
                            </td>

                            <td>{{-- btn group has 2 btns 
                                 btn named "عمليات" wihtout any fonction
                                 and btn toggle (hide and show) drop down list of operations  --}}
                                <div class="btn-group ">
                                    {{--    1btn named "عمليات" wihtout any fonction --}}
                                    {{-- btn-sm to Makes a small button --}}
                                    {{-- btn-outline-success Creates an outlined/bordered button. --}}
                                    <button type="button" class="btn btn-outline-success  btn-sm">العمليات</button>
                                    {{--   2btn toggle (hide and show) drop down list of operations --}}
                                    {{-- To open the dropdown menu, use a button or a link with a class of .dropdown-toggle
                                     and the data-toggle="dropdown" attribute. --}}
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    {{--  the dropdown list  --}}
                                    {{--   Add the .dropdown-menu class to a <div> element to actually build the dropdown menu.
                                     Then add the .dropdown-item class to each element (links or buttons) inside the dropdown menu. --}}

                                    {{--  A dropdown menu is a toggleable menu that allows the user to choose one value from a predefined list: --}}
                                    <div class="dropdown-menu" role="menu" style="">
                                       {{--  the first dropdown item is a href of type submit   to gestion employees list--}} 
                                        <a type="submit" class="dropdown-item font-weight-bold "
                                            href="{{ route('rendements-reservation-employee-list', $rendemenReservation->id) }}">معاينة</a>
                                         {{--  the second dropdown item is a btn in form action 
                                             i ust the form action to has input hidden to print all the list   --}}  
                                        <form action="{{ route('rendements-reservation-pre-print') }}" method="post"
                                            target="_blank">
                                            @csrf
                                            <input type="hidden" name="rendement_reservations_id"
                                                value="{{ $rendemenReservation->id }}">

                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                طباعة القائمة
                                            </button>
                                        </form>
                                          {{--  the thirs dropdown item is a btn in form action 
                                             i ust the form action to has input hidden to print all the list final   --}}  
                                        <form action="{{ route('rendements-reservation-print-final') }}" method="post"
                                            target="_blank">
                                            @csrf
                                            <input type="hidden" name="rendement_reservations_id"
                                                value="{{ $rendemenReservation->id }}">

                                            <button type="submit" class="dropdown-item font-weight-bold " href="#">
                                                طباعة نهائية
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
