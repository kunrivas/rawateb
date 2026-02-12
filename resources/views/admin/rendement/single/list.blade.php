@extends('layouts.admin')
@section('title')
    كشف المردودية الفردي
@endsection
@section('content-title')
    <h1> كشف المردودية الفردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">كشف المردودية </a></li>
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
                        <th scope="col">الثلاثي</th>
                       <th scope="col">العنوان</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rendement_singles as $rendement_single)
                        <tr>
                            <td>{{ $rendement_single->re_megration->YEAR }}</td>
                            
                            {{--using method getArabicMonth in helper/milabrary--}}
                            <td>{{ Mlibrary::getRendament($rendement_single->re_megration->TRIMESTRE) }}</td>
                            <td>
                                {{ $rendement_single->re_megration->TITLE ?? '/' }}
                            </td>
                            <td>
                                {{-- target="_blank" means make the result in new browser window or tab --}}
                                <form action="{{ route('admin-rendement-single-print') }}" method="post" target="_blank">

                                    {{-- using csrf is obligatoire in post method --}}
                                     @csrf 

                                     {{-- input type ="hidden" to send parametres with post methode --}}
                                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                    <input type="hidden" name="IDMEGR" value="{{ $rendement_single->ID_MEGRATION_RE }}">
                                    <input type="hidden" name="ADM" value="{{$rendement_single->ADM }}">

                                    {{--add new parametre (lang) to send with post method 
                                    and affect to her 2 vlaues in chaque submit btns--}}
                                    <button type="submit" name="lang" value="ar"
                                        class="btn text-white btn-primary">عرض </button>
                                    

                                </form>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $rendement_singles->links() }}
        </div>
    </div>
@endsection
