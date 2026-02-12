@extends('layouts.index')
@section('title')
    كشف الراتب الفردي
@endsection
@section('content-title')
    <h1> كشف راتب سنوي للموظف </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف راتب</a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
    <li class="breadcrumb-item"><a href="#">سنوي</a></li>
@endsection




@section('contents')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-50 border border-dark ">
                <h5 class="card-header bg-dark ">
                    <p class="text-center ">كشف الراتب السنوي</p>
                </h5>
                <form class="row" method="POST" action="{{ route('salary-single-year-print') }}" target="_blank">
                    <div class="card-body ">
                        <h5 class="card-title  mb-2">رمز الموظف : {{ $employee->MATRI }}</h5>
                        <h5 class="card-title mb-4">اللقب والإسم : {{ $employee->NOMA }} {{ $employee->PRENOMA }}</h5>

                        <div class="border p-2 bg-dark">
                            <p class="text-center mb-2">إختر الشهر المرجعي:</p>
                            <select class="col mb-2 text-center" name="id_megration_select">
                                {{ $id_megration_select = 0 }}
                                @foreach ($salary_singles as $key => $value)
                                    <option value="{{ $value->megration->ID_MEGRATION }}"
                                        @if ($id_megration_select == $value->megration->ID_MEGRATION) selected @endif>
                                        {{ Mlibrary::getArabicMonth($value->megration->MONTH) }}
                                        {{ $value->megration->YEAR }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                        <input type="hidden" name="ADM" value="{{ $salary_singles[0]->ADM }}">






                        <div class="d-flex flex-row mt-3">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="p-2">
                                <button type="submit" name="lang" value="ar" 
                                    class="btn text-white btn-primary">عربي</button>
                            </div>
                            <div class="p-2">
                                <button type="submit" name="lang" value="fr"
                                    class="btn text-white btn-success">فرنسي</button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
