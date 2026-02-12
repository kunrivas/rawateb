@extends('layouts.index')
@section('title')
    كشف التمدرس الجماعي
@endsection
@section('content-title')
    <h1> كشف التمدرس الجماعي
    </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف تمدرس</a></li>
    <li class="breadcrumb-item"><a href="#">جماعي</a></li>
@endsection

@section('contents')
    <div class="row">
        <div class="col">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th class="col-md-3" scope="col">السنة</th>
                        <th class="col-md-3" scope="col">الثلاثي</th>
                        <th class="col-md-6" scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ta_megrations as $ta_megration)
                        <tr>
                            <td>{{ $ta_megration->YEAR }}</td>
                            <td>{{ $ta_megration->TITLE }}</td>


                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm">طباعة الكشف الجماعي</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu  dropdown-menu-bottom" role="menu" style="">
                                        @foreach ($adms as $adm)
                                            @if ($adm->ADM != '0')
                                                <form class="dropdown-item" style="padding: 0;" target="_black"
                                                    action="{{ route('tamadres-global-print') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="ID_MEGRATION_TA"
                                                        value="{{ $ta_megration->ID_MEGRATION_TA }}">
                                                    <input type="hidden" name="ADM" value="{{ $adm->ADM }}">
                                                    <input class="btn-list" type="submit" value="{{ $adm->LIBTABA }}" />



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
         {{--    {{ $ta_megrations->links() }} --}}
        </div>
    </div>
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
