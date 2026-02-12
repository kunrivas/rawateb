@extends('layouts.index')
@section('title')
    كشف العمل والأجر الفردي
@endsection
@section('content-title')
    <h1> كشف العمل والأجر الفردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف العمل والأجر </a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
@endsection


@section('contents')
    <div class="row justify-content-center">
        <div class="card w-50 border border-dark ">
            <h5 class="card-header bg-dark ">
                <p class="text-center ">المعطيات المتعلقة بالموظف</p>
            </h5>
            <form class="row" method="POST" action="{{ route('ats-single-print') }}" target="_blank">
                <div class="card-body ">
                    <h5 class="card-title  mb-4">رمز الموظف : {{ $employee->MATRI }}</h5>
                    <h5 class="card-title mb-4">اللقب والإسم : {{ $employee->NOMA }} {{ $employee->PRENOMA }}</h5>

                    <div class="form-group">
                        <label>السنة</label>
                        <select class="custom-select" name="year" id="inputGroupSelect01" >
                            <option selected>اختر</option>

                            {{--  getYearRange, is designed to generate an array of years within a given range
                                    it is defined  in  milbrary 
                                    // => [2010, 2009, 2008, ... ]
                                    date('Y') is actulay year in system  --}}

                            @foreach (Mlibrary::getYearRange(date('Y') + 5, date('Y') - 5) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="month">
                        <label> الشهرالمرجعي </label>
                        <select class="custom-select" name="month" >
                            <option selected>اختر</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}">
                                    {{ Mlibrary::getArabicMonth($month) }}
                                </option>
                            @endfor

                        </select>
                    </div>
                    <div class="form-group" id="numberMonth" >
                        <label> عدد الاشهر </label>
                        <select class="custom-select" name="numberMonth">
                            <option selected>اختر</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}">{{ $month }}
                                </option>
                            @endfor

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="forInformations ">للإستعلامات</label>
                        <input class="" type="checkbox" name="forInformations" id="forInformations"
                            {{-- onclick="handleCheckboxChange('forInformations', 'forRendement')" --}}>
                    </div>
                    <div class="form-group">
                        <label for="forInformations ">إحتساب المردودية</label>
                        <input class="" type="checkbox" name="forRendement" id="forRendement"
                            {{-- onclick="handleCheckboxChange('forRendement', 'forInformations')" --}}>
                    </div>
                    <div class="form-group">
                        <label for="forInformations ">ترتيب الأشهر تصاعدي</label>
                        <input class="" type="checkbox" name="forOrderMonths" id="forOrderMonths">
                    </div>

                    {{-- inputs hidden to sent with request --}}
                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="d-flex flex-row  mb-3">
                        <div class="p-2">
                            <button type="submit" name="clicked" value="page1" class="btn text-white btn-primary">الصقحة
                                الأولى</button>
                        </div>

                        <div class="p-2">
                            <button type="submit" name="clicked" value="page2" class="btn text-white btn-success">الصفحة
                                الثانية</button>
                        </div>

                    </div>


                </div>
            </form>
        </div>
    </div>
{{-- 
    <script>
        function handleCheckboxChange(clickedCheckboxId, otherCheckboxId) {
            var clickedCheckbox = document.getElementById(clickedCheckboxId);
            var otherCheckbox = document.getElementById(otherCheckboxId);

            if (clickedCheckbox.checked) {
                // If the clicked checkbox is checked, uncheck the other checkbox
                otherCheckbox.checked = false;
            }
            // If the clicked checkbox is unchecked, you can decide whether to check the other checkbox or leave it unchanged.
        }
    </script> --}}
@endsection
