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

                <form action="{{ route('admin-settings-fonctions-store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>رمز الوظيفة</label>
                        <input type="text" name="CODEFONC" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>الإسم بالفرنسية</label>
                        <input type="text" name="LIBTAB" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>الإسم بالعربية</label>
                        <input type="text" name="LIBTABA" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>الصنف</label>
                        <input type="text" name="CATEG" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>الرقم الإستدلالي</label>
                        <input type="number" step="0.01" name="TAUXPR" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success mt-2">حفظ</button>
                </form>

            </div>
        </div>
    </div>
@endsection
