@extends('layouts.admin')
@section('title')
    كشف منحة التمدرس الفردي
@endsection
@section('content-title')
    <h1> كشف منحة التمدرس الفردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف منحة التمدرس </a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
@endsection


@section('contents')
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">السنة</th>
                        <th scope="col">الثلاثي</th>
                        <th scope="col">إختر</th>
                    </tr>
                </thead>
                <tbody>
              
                    @foreach ($tamadres_singles as $tamadres_single)
                        <tr>
                            <td>{{ $tamadres_single->ta_megration->YEAR }}</td>

                            {{-- using method getArabicMonth in helper/milabrary --}}
                            <td>{{ $tamadres_single->ta_megration->TITLE }}</td>
                            <td>
                                {{-- target="_blank" means make the result in new browser window or tab --}}
                                <form action="{{ route('admin-tamadres-single-print') }}" method="post" target="_blank">

                                    {{-- using csrf is obligatoire in post method --}}
                                    @csrf

                                    {{-- input type ="hidden" to send parametres with post methode --}}
                                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                    <input type="hidden" name="IDMEGR" value="{{ $tamadres_single->ID_MEGRATION_TA }}">
                                    <input type="hidden" name="ADM" value="{{ $tamadres_single->ADM }}">

                                    {{-- add new parametre (lang) to send with post method 
                                    and affect to her 2 vlaues in chaque submit btns --}}
                                    <button type="submit" name="lang" value="ar"
                                        class="btn text-white btn-primary">عرض </button>


                                </form>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
          {{--    {{ $tamadres_singles->links() }}  --}}
        </div>
    </div>
@endsection
