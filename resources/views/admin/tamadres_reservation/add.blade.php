@extends('layouts.admin')
@section('title')
إضافة منحة تمدرس جديدة
@endsection
@section('content-title')
    <h1></h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#"> إضافة منحة جديدة </a></li>
    <li class="breadcrumb-item"><a href="#"> قائمة منح التمدرس </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير حجز التمدرس</a></li>
@endsection



@section('contents')
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> إضافة منحة جديدة </h3>
                </div>


                <form action={{ route('admin-tamadres-store') }} method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label>العنوان</label>
                            <input class="form-control" type="text" name="TITLE">

                        </div>
                        <div class="form-group">
                            <label>السنة</label>
                            <select class="form-control" name="YEAR" required>
                                <option selected>اختر</option>
                                @foreach (Mlibrary::getYearRange(date('Y') + 5, date('Y') - 5) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label>الحالة</label>
                            <select class="form-control" name="STATUS" required>
                                <option selected>اختر</option>
                                <option value="1">مفعل</option>
                                <option value="0">موقف</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit"
                            onClick="this.form.submit(); this.disabled=true; this.value='إرسال ........'; "
                            class="btn btn-success">
                            إضافة منحة جديدة</button>


                    </div>
                </form>
                <!--  <div class="overlay">
                                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                  </div>-->
            </div>



        </div>




    </div>
@endsection

