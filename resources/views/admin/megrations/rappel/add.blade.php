@extends('layouts.admin')
@section('title')
    إضافة حزمة  مخلف
@endsection
@section('content-title')
    <h1></h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#"> إضافة  حزمة مخلف</a></li>
    <li class="breadcrumb-item"><a href="{{ route("admin-megration-salary-index") }}">المخلفات </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير الحزم</a></li>
@endsection



@section('contents')
    <div class="row">

        <div class="col">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إضافة حزمة مخلف جديدة</h3>
                </div>
                <form action="{{ route('admin-megration-rappel-store') }}" method="POST"  enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label>العنوان</label>
                            <input class="form-control" type="text" name="TITLE">
                        </div>
                        <div class="form-group">
                            <label>LOT</label>
                            <input class="form-control" type="LOT" name="LOT">
                        </div>
                        <div class="form-group">
                            <label>السنة</label>
                            <select class="form-control" name="year" required>
                                <option selected>اختر</option>
                                @foreach (Mlibrary::getYearRange(date('Y') + 10, date('Y') - 10) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- the input of zip file  to add  --}}
                        <div class="form-group">
                            <label for="exampleInputFile"> الحزمة الشهرية بصيغة (zip)</label>
                            <div class="file-drop-area">
                                <span class="choose-file-button">إختر الملف</span>
                                <span class="file-message">أو قم بالسحب والافلات هنا.</span>
                                <input class="file-input" type="file" name="megration" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit"
                            onClick="this.form.submit(); this.disabled=true; this.value='إرسال ........'; "
                            class="btn btn-success">
                            إضافة حزمة جديدة</button>


                    </div>
                </form>
              <!--  <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                  </div>-->
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
