@extends('layouts.admin')
@section('title')
    تسيير الوظائف
@endsection
@section('content-title')
    <h1>تسيير الوظائف</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">>تسيير الوظائف</a></li>
    <li class="breadcrumb-item"><a href="#">>قائمة الوظائف</a></li>
@endsection

@section('contents')
    <div class="row">
        <div class="col">
            <div class="mt-4">

                <div class="row mb-2">
                    <div class="col"></div>
                    <div class="col-2">
                        <a href="{{ route('admin-settings-fonctions-create') }}" class="btn btn-primary">إضافة وظيفة </a>
                    </div>
                </div>

                <table class="table table-striped mt-4 text-center">
                    <thead>
                        <tr>
                            <th>رمز الوظيفة</th>
                            <th>اسم الوظيفة بالفرنسية</th>
                            <th>اسم الوظيفة بالعربية</th>
                            <th>الصنف</th>
                            <th>الرقم الاستدلالي</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fonctions as $fonction)
                            <tr>
                                <td>{{ $fonction->CODEFONC }}</td>
                                <td>{{ $fonction->LIBTAB }}</td>
                                <td>{{ $fonction->LIBTABA }}</td>
                                <td>{{ $fonction->CATEG }}</td>
                                <td>{{ $fonction->TAUXPR }}</td>
                                <td>
                                    <a href="{{ route('admin-settings-fonctions-edit', $fonction->CODEFONC) }}"
                                        class="btn btn-sm btn-primary">تعديل</a>

                                    {{--<form action="{{ route('admin-settings-fonctions-destroy', $fonction->CODEFONC) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf 
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('هل تريد حذف هذه الوظيفة')">حذف</button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
