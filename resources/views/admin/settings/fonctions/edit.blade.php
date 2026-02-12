@extends('layouts.admin')
@section('title')
    تسيير الوظائف
@endsection
@section('content-title')
    <h1>تسيير الوظائف</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">>تسيير الوظائف</a></li>
    <li class="breadcrumb-item"><a href="#">إضافة الوظيفة</a></li>
@endsection

@section('contents')
    <div class="row">
        <div class="col">
            <div class="mt-4">

                <form action="{{ route('admin-settings-fonctions-update', ['CODEFONC' => $fonction->CODEFONC]) }}"
                    method="POST">
                    @csrf
                      <div class="form-group">
                        <label>الرمز</label>
                        <input type="text" name="LIBTAB" class="form-control" value="{{ $fonction->CODEFONC }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>الاسم بالفرنسية</label>
                        <input type="text" name="LIBTAB" class="form-control" value="{{ $fonction->LIBTAB }}">
                    </div>
                    <div class="form-group">
                        <label>الاسم بالعربية</label>
                        <input type="text" name="LIBTABA" class="form-control" value="{{ $fonction->LIBTABA }}">
                    </div>
                    <div class="form-group">
                        <label>الصنف</label>
                        <input type="text" name="CATEG" class="form-control" value="{{ $fonction->CATEG }}">
                    </div>
                    <div class="form-group">
                        <label>الرقم الاستدلالي</label>
                        <input type="number" step="0.01" name="TAUXPR" class="form-control"
                            value="{{ $fonction->TAUXPR }}">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">حفظ</button>
                </form>


            </div>
        </div>
    </div>
@endsection
