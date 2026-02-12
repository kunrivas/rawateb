@extends('layouts.admin')
@section('title')
    كشف مخلف المردودية الفردي
@endsection
@section('content-title')
    <h1> كشف مخلف المردودية الفردي
        "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف مخلفات</a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
    <li class="breadcrumb-item"><a href="#">شهري</a></li>
@endsection



@section('contents')
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">السنة</th>
                        <th scope="col">الشهر</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raprend_singles as $raprend_single)
                        <tr>

                            <td>{{ $raprend_single->ra_re_megration->YEAR ?? '؟؟؟' }}</td>
                            <td>{{ $raprend_single->ra_re_megration->TITLE ?? '؟؟؟' }}</td>
                            <td>

                            <td>
                                {{-- target="_blank" means make the result in new browser window or tab --}}
                                <form action="{{ route('admin-rappel-rendement-single-print') }}" method="post"
                                    target="_blank">

                                    {{-- using csrf is obligatoire in post method --}}
                                    @csrf

                                    {{-- input type ="hidden" to send parametres with post methode --}}
                                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                    <input type="hidden" name="ID_MEGRATION_RA_RE"
                                        value="{{ $raprend_single->ID_MEGRATION_RA_RE }}">
                                    <input type="hidden" name="SEQ" value="{{ $raprend_single->SEQ }}">


                                    {{-- add new parametre (lang) to send with post method 
                                        and affect to her 2 vlaues in chaque submit btns --}}
                                    <button type="submit" class="btn text-white btn-primary"> طباعة كشف مخلف المردودية
                                    </button>

                                </form>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
                {{ $raprend_singles->links() }}
            </table>
        </div>
    </div>
@endsection
