@extends('layouts.admin')
{{-- linked by yield in parent view --}}
@section('title')
    طباعة قوائم الحركة
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">طباعة قوائم الحركة</a></li>
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
@endsection

{{-- chang content linked by yield in parent view --}}
@section('contents')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="mt-4">

                <form method="post" action="{{ route('admin-mouvement-single-mouvement-print') }}" target="_blank"> @csrf
                    <div class="card">
                        <h5 class="card-header text-center bg-dark mb-3">خيارات الطباعة</h5>
                        <div class="card-body">
                            <div class="row"> <!-- Dates -->
                                <div class="col-4" style="border: 0.5px solid #dfd9d9; padding-right: 10px;">
                                    <h5 style="text-align: right">الحركة في الفترة بين</h5>
                                    <div>
                                        <div class="form-group"> <label for="start_date">من</label> <input type="date"
                                                class="form-control" id="start_date" name="start_date"
                                                value="{{ $start_date }}"> </div>
                                        <div class="form-group"> <label for="end_date">إلى</label> <input type="date"
                                                class="form-control" id="end_date" name="end_date"
                                                value="{{ $end_date }}"> </div>
                                    </div>
                                </div> <!-- Admins -->
                                <div class="col-4" style="border: 0.5px solid #dfd9d9;padding-right: 10px;">
                                    <h5 style="text-align:right">الإدارة</h5>
                                    <div>
                                        @foreach ($adms as $adm)
                                            @if ($adm->ADM != '0')
                                                <div class="form-check d-flex"> <input class="form-check-input"
                                                        type="checkbox" name="adms[{{ $adm->ADM }}]"
                                                        @if (in_array($adm->ADM, $select_adms)) checked @endif
                                                        id="adm_{{ $adm->ADM }}" checked> <label
                                                        class="form-check-label" for="adm_{{ $adm->ADM }}">
                                                        {{ $adm->LIBTABA }} </label> </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div> <!-- Buttons -->
                                <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                                    <button class="btn btn-info w-100 mb-2" type="submit" name="action" value="print">
                                        طباعة قائمة الحركة
                                    </button>
                                    <button class="btn btn-success w-100" type="submit" name="action" value="excel">
                                        تصدير إلى sql
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                {{--  <table class="table table-striped mt-4" id="emptab">

                <thead>
                    <tr>
                        <th scope="col">الرمز</th>
                        <th scope="col">الإسم</th>
                        <th scope="col">اللقب</th>
                        <th scope="col">تاريخ الميلاد</th>
                        <th scope="col">رقم الضمان الاجتماعي</th>
                        <th scope="col">المؤسسة الجديدة</th>
                        <th scope="col">رمز م الجديدة</th>
                        <th scope="col">المؤسسة الأصلية</th>
                        <th scope="col">رمز م الأصلية</th>
                        <th scope="col">الرتبة </th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($mouvEmployees as $mouvEmployee)
                        <tr>
                            <th>{{ $mouvEmployee->MATRI }}</th>
                            <td>{{ $mouvEmployee->employee->PRENOMA }}</td>
                            <td>{{ $mouvEmployee->employee->NOMA }}</td>

                            @if ($mouvEmployee->employee->DATNAIS)
                                <td>{{ $mouvEmployee->employee->DATNAIS ?? '/' }}</td>
                            @else
                                <td></td>
                            @endif

                            <td>{{ $mouvEmployee->employee->NUMSS ?? '/' }}</td>
                            <td>{{ $mouvEmployee->to_establishment->estab_ar_name ?? '/' }}</td>
                            <td>{{ $mouvEmployee->ESTAB_TO ?? '/' }}</td>

                            <td>{{ $mouvEmployee->from_establishment->estab_ar_name ?? '/' }}</td>
                            <td>{{ $mouvEmployee->ESTAB_FROM ?? '/' }}</td>


                            <td>{{ $mouvEmployee->employee->fonction->LIBTABA ?? '/' }}</td>


                        </tr>
                    @endforeach


                </tbody>

            </table> --}}


            </div>
        </div>
    </div>




@endsection
