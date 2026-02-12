@extends('layouts.index')
@section('title')
    طلب تحويل موظف
@endsection
@section('content-title')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">طلب تحويل موظف </a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
@endsection
@section('contents')
    {{-- div of error msg in controller returning with view  --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


        <div class="row justify-content-center">
            <div class="card col ">
                <h5 class="card-header ">
                    <p class="text-center ">  هل تريد حقا تحويل الموظف ؟ </p>
                </h5>
                <form class="row" method="POST" action="{{ route('director-mouvement-single-confirm') }}">
                    <div class="card-body ">
                        <h5 class="card-title  mb-4">رمز الموظف : {{ $employee->MATRI }}</h5>
                        <h5 class="card-title mb-4">اللقب والإسم : {{ $employee->NOMA }} {{ $employee->PRENOMA }}</h5>
                        </h5>
                        <h5 class="card-title mb-4">تاريخ لازدياد : {{ $employee->DATNAIS }} </h5>
                        <h5 class="card-title  mb-4">تاريخ التوظيف : {{ $employee->DATENT }}</h5>
                        <h5 class="card-title mb-4"> رقم الضمان الاجتماعي : {{ $employee->NUMSS }} </h5>

                        <h5 class="card-title  mb-4"> الرتبة : {{ $employee->fonction->LIBTABA ?? '/' }}</h5>
                        <h5 class="card-title mb-4">الادارة : {{ $employee->adm->LIBTABA ?? '/' }} </h5>

                        {{-- inputs hidden to sent with request --}}
                        <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                        <input type="hidden" name="FROMAFFECT" value="{{ $employee->AFFECT }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="d-flex flex-row-reverse  mb-3">
                            {{-- 2 btn have name "clicked" and 2 values "confirm" and "cancel"  --}}
                            <div class="p-2">
                                <button type="submit" name="clicked" value="cancel"
                                    class="btn text-white btn-danger">إلغاء</button>
                            </div>

                            <div class="p-2">
                                <button type="submit" name="clicked" value="confirm"
                                    class="btn text-white btn-success">تأكيد</button>
                            </div>

                        </div>


                    </div>
                </form>
            </div>
        </div>

@endsection
