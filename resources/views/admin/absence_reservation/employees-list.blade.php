@extends('layouts.admin')
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

    {{-- @if ($absence_reservation->STATUS == 1)
        <div class="d-flex flex-row-reverse bd-highlight">
            <!-- Button to trigger modal -->
            <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal" data-target="#infoModal">إضافة
                غياب</button>
        </div>
    @endif --}}

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
                                          {{--   <a href="{{ route('absence-reservation-cancel', ['id' => $value->absence_id]) }}"
                                                class="btn text-white btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الغياب؟');">
                                                حذف الغياب
                                            </a> --}}
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

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade " id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content " style="width: 650px">
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
                            <div class="col-6 ">
                                <p class="mr-3"><strong>المؤسسة : </strong> <span id="ESTAB"></span>
                                </p>
                            </div> 
                            <div class="col-6">
                                <label class="mr-3" for="establishmentCode"> رمز الموظف : <span id="aMATRI"></span>
                                </label>

                            </div>
                         
                        </div>
                        <div class="row">
                            <div class="col-6 ">
                                <p class="mr-3"><strong>الإسم الكامل : </strong> <span id="NOMA"></span>

                                    <span id="PRENOMA"></span>
                                </p>
                            </div>
                            <div class="col">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الإدارة : </strong> <span id="ADM"></span></p>
                                </div>


                            </div>
                            <div class="col">
                                <div class="d-flex flex-row bd-highlight mb-3">

                                    <p class="mr-3"><strong>الحالة العائلية : </strong> <span id="SITFAM"></span></p>
                                </div>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-6  ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الوظيفة : </strong> <span id="FONCTION"></span></p>

                                </div>
                            </div>
                            <div class="col ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الصنف : </strong> <span id="CATEG"></span></p>
                                </div>
                            </div>
                            <div class="col ">
                                <div class="d-flex flex-row bd-highlight mb-3">
                                    <p class="mr-3"><strong>الدرجة : </strong> <span id="ECH"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger" id="em-info-error" style="display: none">
                        <div>
                            الموظف غير موجود
                        </div>
                    </div>
                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode">نوع الغياب:</label>
                                <select class="form-control" name="atype">
                                    @for ($type = 1; $type <= 7; $type++)
                                        <option value="{{ $type }}">
                                            {{ Mlibrary::getAbsenceType($type) }}
                                        </option>
                                    @endfor
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode">عدد الأيام:</label>
                                <input type="text" class="form-control" id="anbrdays" name="anbrdays">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode">تاريخ البداية:</label>
                                <input type="date" class="form-control" id="adayfrom" name="adayfrom">

                            </div>
                        </div>
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode">تاريخ النهاية:</label>
                                <input type="date" class="form-control" id="adayto" name="adayto">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm m-1 btn-primary" style="visibility: hidden;"
                        id="addabsence">حفظ </button>
                    <button type="button" class="btn btn-sm m-1 btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {


            // Function to fetch employee data
            function fetchEmployeeData(MATRI) {

                // Clear the content of all spans
                document.getElementById("aMATRI").textContent = "";
                document.getElementById("ESTAB").textContent = "";
                document.getElementById("NOMA").textContent = "";
                document.getElementById("PRENOMA").textContent = "";
                document.getElementById("ADM").textContent = "";
                document.getElementById("SITFAM").textContent = "";
                document.getElementById("CATEG").textContent = "";
                document.getElementById("ECH").textContent = "";


                fetch(`/absence/reservation/get-employee/${MATRI}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById("em-info-error").style.display = "none";
                        document.getElementById("em-info").style.display = "block";
                        document.getElementById("addabsence").style.display = "block";
                        // Set the fetched data to input fields
                        document.getElementById("aMATRI").textContent = data.MATRI;
                        document.getElementById("ESTAB").textContent = data.establishment ? 
                        data.establishment.estab_ar_name : ''; 
                        document.getElementById("NOMA").textContent = data.NOMA;
                        document.getElementById("PRENOMA").textContent = data.PRENOMA;
                        document.getElementById("ADM").textContent = data.ADM;
                        document.getElementById("FONCTION").textContent = data.fonction ? data.fonction
                            .LIBTABA : '';
                        document.getElementById("SITFAM").textContent = data.SITFAM;
                        document.getElementById("CATEG").textContent = data.CATEG;
                        document.getElementById("ECH").textContent = data.ECH;
                        document.getElementById("addabsence").style.visibility = "visible";
                    })
                    .catch(error => {
                        document.getElementById("em-info-error").style.display = "block";
                        document.getElementById("em-info").style.display = "none";
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
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("addabsence").addEventListener("click", function() {

                var MATRI = document.getElementById("aMATRI").textContent;
                var areservationId = document.getElementById("areservationId").value;
                var atype = document.querySelector('select[name="atype"]').value;
                var anbrdays = document.getElementById("anbrdays").value;
                var adayfrom = document.getElementById("adayfrom").value;
                var adayto = document.getElementById("adayto").value;

                alert(MATRI+areservationId+atype+anbrdays+adayfrom+adayto);

                // Prepare data to send
                //var csrfToken = updateCsrfToken();
                var formData = new FormData();
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content"));
                formData.append("aMATRI", MATRI);
                formData.append("areservationId", areservationId);
                formData.append("atype", atype);
                formData.append("anbrdays", anbrdays);
                formData.append("adayfrom", adayfrom);
                formData.append("adayto", adayto);

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST",
                    "/absence/reservation/insert-absence"); // Replace with your backend endpoint

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert("تمت إضافة الغياب بنجاح");
                            var modal = document.getElementById("infoModal");
                            modal.classList.remove("show");
                            modal.style.display = "none";
                            modal.setAttribute("aria-hidden", "true");
                            window.location.reload();

                        } else if (xhr.status === 422) { // Unprocessable Entity (Validation Error)
                            var response = JSON.parse(xhr.responseText);
                            var errorMessage = response.errors.join("\n");
                            alert("هناك خطأ في المدخلات:\n" + errorMessage);
                        } else {

                            alert("هناك خطأ");

                        }
                    }
                };

                xhr.send(formData);
            });

        });
    </script>

@endsection
