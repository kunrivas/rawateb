@extends('layouts.admin')
@section('title')
    بيانات الموظفين
@endsection
@section('content-title')
    <h1></h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">تعديل معلومات موظف</a></li>
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
    <li class="breadcrumb-item"><a href="#"> تسير الموظفين</a></li>
@endsection



@section('contents')
    <div class="row">

        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    هنالك خطأ في حجز المعلومات
                </div>
            @endif
            <div class="card w-100">
                <div class="card-header">
                    <h3 class="card-title">تعديل معلومات موظف</h3>
                </div>


                <form action="{{ route('admin-tresor-store') }}" method="POST">
                       <div class="card-body p-5">
                        @csrf
                        <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                        <input type="hidden" name="AFFECT" value="{{ $employee->AFFECT }}">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold h5">الإسم</label>
                                <input class="form-control form-control-lg" type="text" name="PRENOMA"
                                    value="{{ $employee->PRENOMA }}" readonly>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="font-weight-bold h5">اللقب</label>
                                <input class="form-control form-control-lg" type="text" name="NOMA"
                                    value="{{ $employee->NOMA }}" readonly>
                            </div>
                        </div>
                        {{-- </div> --}}
                        {{--  <div class="row">
                            <div class="col form-group">
                                 <label class="font-weight-bold h5">الاسم بالفرنسية</label>
                               <input class="form-control form-control-lg" type="text" name="PRENOM" value="{{ $employee->PRENOM }}">
                            </div>
                            <div class="col form-group">
                                 <label class="font-weight-bold h5">اللقب بالفرنسية</label>
                               <input class="form-control form-control-lg" type="text" name="NOM" value="{{ $employee->NOM }}">
                            </div>
                        </div> --}}
                        <div class="row">
                            {{--      <div class="col form-group">
                                 <label class="font-weight-bold h5">تاريخ الميلاد</label>
                               <input class="form-control form-control-lg" type="date" name="DATNAIS"
                                    value="{{ \Carbon\Carbon::parse($employee->DATNAIS)->format('Y-m-d') }}">
                            </div> --}}
                            <div class="col form-group">
                                 <label class="font-weight-bold h5">رقم الضمان الاجتماعي</label>
                                <input class="form-control form-control-lg" type="text" 
                                    value="{{ $employee->NUMSS }}" readonly>
                            </div>
                        </div>

                        {{--    <div class="col form-group">
                             <label class="font-weight-bold h5">Nom et Prenom </label>
                           <input class="form-control form-control-lg" type="text" name="NOMPRENOM" value="{{ $employee->NOMPRENOM }}">
                        </div> --}}
                        <div class="row">
                            <div class="col form-group">
                                 <label class="font-weight-bold h5">تاريخ الميلاد</label>
                                <input class="form-control form-control-lg " type="date" name="DATNAIS"
                                    value="{{ \Carbon\Carbon::parse($employee->DATNAIS)->format('Y-m-d') }}">
                            </div>
                            <div class="col form-group">
                                 <label class="font-weight-bold h5"> رقم التعريف الوطني (NIN)</label>
                                <input class="form-control form-control-lg" type="text" name="NIN"
                                    value="{{ $employee->NIN }}"  style="
                                        font-size: xxx-large;
                                        font-weight: 600;
                                        color: blue;
                                    " maxlength="18"
                                >
                            </div>
                            {{--  <div class=" col form-group">
                                 <label class="font-weight-bold h5">RIB</label>
                               <input class="form-control form-control-lg" type="text" name="RIB"
                                    value="{{ $employee->RIB }}">
                            </div> --}}
                        </div>

                        {{--   <div class="form-group">
                             <label class="font-weight-bold h5">Adresse</label>
                           <input class="form-control form-control-lg" type="text" name="address" value="{{ $employee->address }}">
                        </div>
 --}}

                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit"
                            onClick="this.form.submit(); this.disabled=true; this.value='إرسال ........'; "
                            class="btn btn-success">
                            حفظ المعلومات</button>


                    </div>
                </form>

            </div>



        </div>




    </div>
@endsection
@section('css')
    <style>
        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            max-width: 100%;
            padding: 25px;
            border: 1px dashed #5d6d7e;
            border-radius: 3px;
            transition: 0.2s;
            background: #e5e4e4;
            width: 100%;
            text-align: center;
            justify-content: center;

        }

        .choose-file-button {
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            padding: 8px 15px;
            margin-right: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .file-message {
            font-size: small;
            font-weight: 300;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0;

        }

        .mt-100 {
            margin-top: 100px;
        }
    </style>
@endsection
@section('js')
    <script>
        $(document).on('change', '.file-input', function() {


            var filesCount = $(this)[0].files.length;

            var textbox = $(this).prev();

            if (filesCount === 1) {
                var fileName = $(this).val().split('\\').pop();
                textbox.text(fileName);
            } else {
                textbox.text(filesCount + ' files selected');
            }
        });
    </script>
@endsection
