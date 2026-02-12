@extends('layouts.absence')
@section('title')
    حجز الغيابات
@endsection
@section('content-title')
    <h1> حجز الغيابات
    </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز الغيابات </a></li>
@endsection

@section('contents')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{--  search form  --}}
    <form method="post" action="{{-- {{ route('rendements-reservation-employee-list', $rendementReservation->id) }} --}}">
        @csrf
        <div class="col-6 input-group mb-3 row">
            {{--  label search --}}
            <div class="col-2  text-center">إبحث عن</div>

            <div class="col-8" style="position: relative">
                {{--  input search --}}
                <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                    value="{{ $search }}">
                {{-- dropdown filter --}}
                <div class="dropdown" style="position: absolute;top:0;left:9px">
                    {{--  btn of  open filter  dropdown --}}
                    <button class="btn  " type="button" data-toggle="dropdown"
                        style="background: transparent; height: 34px;          border-right: 1px solid #ced4da;
                          ">
                        {{-- btn icon --}}
                        <i class="fa fa-filter"></i>
                    </button>
                    {{--   menu of dropdown --}}
                    <div class="dropdown-menu dropdown-menu-right  "
                        style="width: 300px;padding: 10px;     border: 1px solid gray;
                    ">
                        <div class="row">

                            {{--   the part  of adms  --}}
                            <div class="col" style="border-right: 0.5px solid #dfd9d9;padding-right: 10px;">
                                <h5 style="text-align: right">الادارة</h5>
                                <div>
                                    @foreach ($adms as $adm)
                                        {{--   condition if to ignor  'الكل' --}}
                                        @if ($adm->ADM != '0')
                                            <div class="form-check d-flex">
                                                <input class="form-check-input" type="checkbox"
                                                    name="adms[{{ $adm->ADM }}]" {{-- condition if this adm->ADM is in select_adms array make it checked --}}
                                                    @if (in_array($adm->ADM, $select_adms)) checked @endif
                                                    id="flexCheckIndeterminate">
                                                {{-- checkbox label of affichage --}}
                                                <label class="form-check-label" for="flexCheckIndeterminate">
                                                    {{ $adm->LIBTABA }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            {{--   the part  of status  --}}

                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
        </div>
    </form>

    @if ($absence_reservation->STATUS == 1)
        <div class="d-flex flex-row-reverse bd-highlight">
            <!-- Button to trigger modal -->
            <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal" data-target="#infoModal">إضافة
                غياب</button>
        </div>
    @endif

    {{-- add absence reservation employee --}}


    {{-- table absence reservation employees --}}
    <div class="row">
        <div class="col">

            @csrf
            {{--  <input type="hidden" name="rendement_reservations_id" value="{{ $rendementReservation->id }}"> --}}
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col">المؤسسة</th>
                        <th scope="col">عدد الأيام</th>
                        <th scope="col">تاريخ البداية</th>
                        <th scope="col">تاريخ الإنتهاء</th>

                        <th scope="col">نوع الغياب</th>

                        @if ($absence_reservation->STATUS != 0)
                            <th scope="col"> العمليات</th>
                        @endif

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($absence_reservation_employees))
                        @foreach ($absence_reservation_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->NOMA }}</td>
                                <td>{{ $value->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->employee->establishment->estab_ar_name ?? '' }}</td>
                                <td>{{ $value->NBR_DAYS }}</td>
                                <td>{{ $value->DAY_FROM }}</td>
                                <td>{{ $value->DAY_TO }}</td>
                                <td>{{ Mlibrary::getabsenceType($value->ABSENCE_TYPE) ?? '' }}</td>
                                {{-- <td>{{ Mlibrary::getabsenceType($value->absence_type) ?? '' }}</td>
                                <td>{{ $value->absence_val ?? '' }}</td>
                                <td>{{ $value->absence_date ?? '' }}</td> --}}
                                @if ($absence_reservation->STATUS == 1)
                                    <td>
                                        <div class="d-flex justify-content-center ml-2 ">
                                            {{--     <a href="{{ route('salary-single-list', ['id' => $value->id]) }}"
                                        class="btn text-white btn-primary  ml-2">تعديل المخلف</a> --}}
                                            <a href="{{ route('absence-reservation-cancel', ['id' => $value->absence_id]) }}"
                                                class="btn text-white btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الغياب؟');">
                                                حذف الغياب
                                            </a>
                                        </div>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="10">There are no data.</td>

                        </tr>
                    @endif
                </tbody>

            </table>
            {{ $absence_reservation_employees->appends(request()->input())->links() }}

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade " id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content " style="width: 800px">
                <div class="modal-header  text-center ">
                    <h5>
                        معلومات الغياب </h5>
                    <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="establishmentCode">أدخل رمز الموظف:</label>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="hidden" id="areservationId" value="{{ $absence_reservation_id }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="MATRI" name="MATRI">
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" id="searchEmp" class="btn btn-sm btn-warning">إبحث</button>
                        </div>
                    </div>

                    <div class="em-info alert alert-info" id="em-info" style="display: none">
                        {{--  <div class="row">
                            <div class="col">
                                <label for="establishmentCode"> معلومات الموظف : <span id="aMATRI"></span> </label>

                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mr-3" for="establishmentCode" style="color: black;"><strong> رمز الموظف
                                        :</strong> <span id="aMATRI"></span>
                                    </h3>
                            </div>
                            <div class="col-6">
                                <h5 class="mr-3" style="color: black;"><strong>الإسم الكامل : </strong> <span
                                        id="NOMA"></span>
                                    <span id="PRENOMA"></span>
                                    </h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 ">
                                <h5 class="mr-3" style="color: black;"><strong> رمز المؤسسة: </strong> <span
                                        id="CODESTAB"></span>
                                    </p>
                            </div>
                            <div class="col-6 ">
                                <h5 class="mr-3" style="color: black;"><strong>المؤسسة : </strong> <span
                                        id="ESTAB"></span>
                                    </p>
                            </div>
                            {{--     <div class="col">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الإدارة : </strong> <span id="ADM"></span></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex flex-row bd-highlight mb-3">

                                    <p class="mr-3"><strong>الحالة العائلية : </strong> <span id="SITFAM"></span></p>
                                </div>

                            </div> --}}


                        </div>
                        <div class="row">
                            <div class="col-6  ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <h5 class="mr-3" style="color: black;"><strong>الوظيفة : </strong> <span
                                            id="FONCTION"></span></h5>

                                </div>
                            </div>
                            <div class="col-2">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <h5 class="mr-2" style="color: black;"><strong>الإدارة : </strong> <span
                                            id="ADM"></span></h5>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <h5 class="mr-3" style="color: black;"><strong>تاريخ الميلاد : </strong> <span
                                            id="BIRTHDAY"></span></h5>
                                </div>
                            </div>
                            {{--   <div class="col ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الصنف : </strong> <span id="CATEG"></span></p>
                                </div>
                            </div>
                            <div class="col ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الدرجة : </strong> <span id="ECH"></span></p>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="alert alert-danger" id="em-info-error" style="display: none">
                        <div>
                            الموظف غير موجود
                        </div>
                    </div>
                    {{--  @if ($absence_reservation->Type == 0) 
                    <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div>نوع الغياب:</div>
                                    <div class="row" style="justify-content: center;">

                                        @for ($type = 1; $type <= 6; $type++)
                                            <button id="btn-type-{{ $type }}" type="button"
                                                onClick="onClickType({{ $type }})"
                                                class="btn btn-light col-3 m-2" style="font-size: 14px;">
                                                {{ Mlibrary::getAbsenceType($type) }}
                                            </button>
                                        @endfor

                                    </div>
                                </div>
                            </div>
                        </div> 
                        @endif
                        --}}
                    <table class="table table-bordered" id="absenceTable">
                        <thead>
                            <tr>

                                <th>نوع الغياب</th>

                                <th>تاريخ البداية</th>
                                <th>تاريخ النهاية</th>
                                <th>عدد أيام الغياب</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be added dynamically here -->
                        </tbody>
                    </table>

                    <button type="button" id="addRowBtn" class="btn btn-primary btn-sm">إضافة غياب جديد</button>

                    {{--    <div class="row">
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode" style="text-align: center">تاريخ البداية</label>
                                <input type="date" class="form-control abs-date" id="adayfrom" name="adayfrom">
                            </div>
                        </div>
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode" style="text-align: center">تاريخ النهاية</label>
                                <input type="date" class="form-control abs-date" id="adayto" name="adayto">
                            </div>
                        </div>
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode" style="text-align: center">عدد أيام الغياب</label>
                                <span id="number-abs" class="form-control" style="text-align: center">/</span>
                                <label for="establishmentCode" style="text-align: center">عدد أيام الغياب</label>
                                <span id="number-abs" class="form-control" style="text-align: center">/</span>
                            </div>
                        </div>
                    </div>
 
                </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm m-1 btn-primary" style="visibility: hidden;"
                            id="addabsence">حفظ </button>
                        <button type="button" class="btn btn-sm m-1 btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    {{-- script of get-employee  --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to fetch employee data
            function fetchEmployeeData(MATRI) {

                // Clear the content of all spans
                document.getElementById("aMATRI").textContent = "";
                document.getElementById("CODESTAB").textContent = "";
                document.getElementById("ESTAB").textContent = "";
                document.getElementById("NOMA").textContent = "";
                document.getElementById("PRENOMA").textContent = "";
                document.getElementById("ADM").textContent = "";
                document.getElementById("BIRTHDAY").textContent = "";
                /*      document.getElementById("SITFAM").textContent = "";
                     document.getElementById("CATEG").textContent = "";
                     document.getElementById("ECH").textContent = ""; */


                fetch(`/rawateb/absence/reservation/get-employee/${MATRI}`)
                    .then(async response => {
                        // If the response is NOT OK, try to read Laravel's JSON error
                        if (!response.ok) {
                            let errorMessage = 'حدث خطأ في الاتصال بالخادم';
                            try {
                                const errorData = await response.json();
                                if (errorData.error) errorMessage = errorData.error;
                            } catch (e) {
                                // response not JSON (ignore)
                            }
                            throw new Error(errorMessage);
                        }

                        return response.json();
                    })
                    .then(data => {
                        document.getElementById("em-info-error").style.display = "none";
                        document.getElementById("em-info").style.display = "block";
                        document.getElementById("addabsence").style.display = "block";
                        // Set the fetched data to input fields
                        document.getElementById("aMATRI").textContent = data.MATRI;
                        document.getElementById("CODESTAB").textContent = data.establishment ?
                            data.establishment.estab_rawateb_user : '';
                        document.getElementById("ESTAB").textContent = data.establishment ?
                            data.establishment.estab_ar_name : '';
                        document.getElementById("NOMA").textContent = data.NOMA;
                        document.getElementById("PRENOMA").textContent = data.PRENOMA;
                        document.getElementById("ADM").textContent = data.ADM;
                        document.getElementById("FONCTION").textContent = data.fonction ? data.fonction
                            .LIBTABA : '';
                        document.getElementById("BIRTHDAY").textContent = data.DATNAIS ? data.DATNAIS : '';
                        /*   document.getElementById("SITFAM").textContent = data.SITFAM;
                          document.getElementById("CATEG").textContent = data.CATEG;
                          document.getElementById("ECH").textContent = data.ECH; */
                        document.getElementById("addabsence").style.visibility = "visible";
                    })
                    .catch(error => {
                        // Show the specific error message
                        // Show Laravel's error message
                        const errorBox = document.getElementById("em-info-error");
                        errorBox.textContent = error.message;
                        errorBox.style.display = "block";
                        
                        document.getElementById("em-info").style.display = "none";
                        //document.getElementById("addabsence").style.visibility = "visible";
                        document.getElementById("addabsence").style.visibility = "hidden";
                    });
            }

            // Event listener for employee ID input
            document.getElementById("searchEmp").addEventListener("click", function() {
                var MATRI = document.getElementById("MATRI").value.trim(); // Get the entered ID
                if (MATRI) {
                    // If ID is not empty, fetch employee data
                    fetchEmployeeData(MATRI);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Add new row for an absence entry
            $("#addRowBtn").click(function() {
                let rowHtml = `
                    <tr>
                          @if ($absence_reservation->Type == 0)
                        <td>
                          <select class="form-control atype-select"> 
                          @for ($type = 1; $type <= 6; $type++)
                          <option value="{{ $type }}">{{ Mlibrary::getAbsenceType($type) }}</option>
                         @endfor
                         </select>
                        </td>
                           @else
                            <td>
                           <select class="form-control atype-select">
                                @for ($type = -1; $type <= -1; $type++)
                                    <option value="{{ $type }}">{{ Mlibrary::getAbsenceType($type) }}</option>
                                @endfor
                            </select>
                            </td>
                           @endif
                        <td><input type="date" class="form-control adayfrom"></td>
                        <td><input type="date" class="form-control adayto"></td>
                        <td><span class="number-abs form-control" style="text-align: center;">/</span></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">حذف</button></td>
                    </tr>
                `;
                $("#absenceTable tbody").append(rowHtml);
            });

            // Remove row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });

            // Calculate absence days whenever date fields change
            $(document).on('input', '.adayfrom, .adayto', function() {
                const row = $(this).closest('tr');
                const adayfrom = new Date(row.find('.adayfrom').val());
                const adayto = new Date(row.find('.adayto').val());
                const days = Math.round((adayto - adayfrom) / (1000 * 60 * 60 * 24)) + 1;

                if (days > 0) {
                    row.find('.number-abs').text(days).css("color", "green");
                } else {
                    row.find('.number-abs').text("خطأ في كتابة التواريخ").css("color", "red");
                }
            });



            // Submit all absences for the employee
            $("#addabsence").click(function() {

                let MATRI = $("#aMATRI").text();
                //let MATRI = "0000002968"; 
                let areservationId = $("#areservationId").val();
                //let atype = -1;
                let absences = [];

                $("#absenceTable tbody tr").each(function() {
                    let atype = $(this).find('.atype-select').val();
                    let adayfrom = $(this).find('.adayfrom').val();
                    let adayto = $(this).find('.adayto').val();
                    let anbrdays = $(this).find('.number-abs').text();

                    absences.push({
                        MATRI,
                        areservationId,
                        atype,
                        adayfrom,
                        adayto,
                        anbrdays
                    });
                });

                // alert(absences[0]);
                // Send AJAX request
                $.ajax({
                    url: "/rawateb/absence/reservation/insert-absence",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        absences: absences
                    }),
                    success: function(response) {
                        handleResponse(response);
                    },
                    error: function() {
                        alert("هناك خطأ");
                        // handleResponse(response);
                    }
                });
            });

            function handleResponse(response) {
                if (response.status === "deplicated") {
                    alert(" هنالك خطأ في الغياب :" + response.numAbsEroor + "\n" +
                        "لديك تكرار الرجاء التأكد من التواريخ :\n" + " من " + response.data1 + " إلى " +
                        response
                        .data2);
                    localStorage.setItem("triggerButtonEvent", "true");
                    $("#infoModal").removeClass("show").hide().attr("aria-hidden", "true");
                    window.location.reload();
                } else if (response.status === "add") {
                    alert("تم الإضافة بنجاح");
                    localStorage.setItem("triggerButtonEvent", "true");
                    $("#infoModal").removeClass("show").hide().attr("aria-hidden", "true");
                    window.location.reload();

                } else if (response.status === "plus") {
                    alert(" هنالك خطأ في الغياب :" + response.numAbsEroor + "\n" +
                        `الرجاء التأكد من عدد الايام أصبح يفوق 30 :\nعدد الايام :` + response.data);
                    localStorage.setItem("triggerButtonEvent", "true");
                    $("#infoModal").removeClass("show").hide().attr("aria-hidden", "true");
                    window.location.reload();
                } else if (response.status === "end") {
                    alert("تم إغلاق الحجز");
                    $("#infoModal").removeClass("show").hide().attr("aria-hidden", "true");
                    window.location.reload();
                }
            }

        });

        $(document).ready(function() {
            if (localStorage.getItem("triggerButtonEvent") === "true") {
                // Programmatically trigger the event that would happen if the button was clicked
                $("#infoModal").modal('show');
                // Remove the flag to avoid triggering it again on subsequent reloads
                localStorage.removeItem("triggerButtonEvent");
            }
        });
    </script>
@endsection
