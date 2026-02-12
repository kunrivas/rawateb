@extends('layouts.admin')
@section('title')
    كشف المخلفات الفردي
@endsection
@section('content-title')
    <h1> كشف المخلفات الفردي للموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
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
                    @foreach ($rappel_singles as $rappel_single)
                        <tr>

                            <td>{{ $rappel_single->ra_megration->YEAR ?? '؟؟؟' }}</td>
                            <td>{{ $rappel_single->ra_megration->TITLE ?? '؟؟؟' }}</td>
                            <td>

                            <td>
                                {{-- target="_blank" means make the result in new browser window or tab --}}
                                <form action="{{ route('admin-rappel-single-print') }}" method="post" target="_blank">

                                    {{-- using csrf is obligatoire in post method --}}
                                    @csrf

                                    {{-- input type ="hidden" to send parametres with post methode --}}
                                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                    <input type="hidden" name="ID_MEGRATION_RA"
                                        value="{{ $rappel_single->ID_MEGRATION_RA }}">
                                    <input type="hidden" name="SEQ" value="{{ $rappel_single->SEQ }}">


                                    {{-- add new parametre (lang) to send with post method 
                                        and affect to her 2 vlaues in chaque submit btns --}}
                                    <button type="submit" class="btn text-white btn-primary"> طباعة كشف المخلف</button>

                                </form>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $rappel_singles->links() }}
        </div>
    </div>
@endsection
