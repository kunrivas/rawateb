@extends('layouts.admin')
@section('title')
    إضافة الحزم المردودية
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
                    {{ $errors }} هنالك خطأ في حجز المعلومات
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل معلومات موظف</h3>
                </div>


                <form action="{{ route('root-user-store') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col form-group">
                                <label>إسم المستخدم</label>
                                <input class="form-control" type="text" value="{{ $user->user_username }}" disabled>
                            </div>
                            <div class=" col form-group">
                                <label>الاسم و اللقب</label>
                                <input class="form-control" type="text" name="user_fullname"
                                    value="{{ $user->user_fullname }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label>الرمز الوظيفي</label>
                                <input class="form-control" type="text" name="user_profession_code"
                                    value="{{ $user->user_profession_code }}">
                            </div>
                            <div class="col form-group">
                                <label>الوظيفة </label>
                                <input class="form-control" type="text" name="user_profession"
                                    value="{{ $user->user_profession }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label>رقم الهاتف</label>
                                <input class="form-control" type="text" name="user_mobile"
                                    value="{{ $user->user_mobile }}">
                            </div>

                            <div class="col form-group">
                                <label>البريد االكتروني</label>
                                <input class="form-control" type="text" name="user_email"
                                    value="{{ $user->user_email }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label>حالة الحساب</label>
                                <select class="form-control" name="user_status" required>

                                    <div class="form-check d-flex">
                                        <option value="0" @if ($user->user_status == 0) selected @endif>غير مفعل
                                        </option>
                                        <option value="1" @if ($user->user_status == 1) selected @endif> مفعل
                                        </option>
                                    </div>

                                </select>
                            </div>


                        </div>
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
