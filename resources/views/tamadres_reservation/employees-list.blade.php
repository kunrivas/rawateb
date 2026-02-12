@extends('layouts.index')
@section('title')
    حجز منحة التمدرس
@endsection
@section('content-title')
    <h1> حجز منحة التمدرس </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز منحة التمدرس </a></li>
@endsection
@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }

        tr.saved {
            background: #00800030;
        }

        tr.new {
            background: #ff000036;
        }

        tr.saved-0 {
            background: #ffa50040;
        }

        tr.new td,
        tr.saved td {
            background: transparent;
        }
    </style>
@endsection
@section('contents')
    {{-- 
         the cards of statistics the datas from rendement_reservations_statistics 
     --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-user "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"> عدد الموظفين الإجمالي</span>
                    <span class="info-box-number"> {{ $tamadres_reservations_statistic->TOTAL ??"0"}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين تم حجز منحهم</span>
                    <span class="info-box-number">{{ $tamadres_reservations_statistic->RESERVED ??"0"}} </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa fa-minus "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين لم يتم حجز منحهم</span>
                    <span class="info-box-number">
                        {{ $tamadres_reservations_statistic->TOTAL??0 - $tamadres_reservations_statistic->RESERVED??0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{--  
        form for search and filtrage 
     --}}

    <form method="post"
        action="{{ Route('tamadres_reservation-employees-list', ['tamadres_reservation_id' => $tamadres_reservation->tamadres_reservation_id]) }}">
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

    @if ($tamadres_reservation->STATUS == 1)
        <div class="d-flex flex-row-reverse bd-highlight">
            <!-- Button to trigger modal add tamadres -->
            <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal" data-target="#infoModal">إضافة
                منحة</button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            @csrf
            <input type="hidden" name="tamadres_reservation_id"
                value="{{ $tamadres_reservation->tamadres_reservation_id }}">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col"> عدد الأولاد المتمدرسين </th>
                        <th scope="col"> الملاحظات</th>
                        <th scope="col">العمليات </th>
                        <th scope="col"> </th>

                    </tr>
                </thead>
                <tbody>
                    {{--  verify condition (if) tamadres_reservation_employees is not empty 
                       to togle (show and hide) buttons of opperations  --}}
                    @if (!empty($tamadres_reservation_employees) && $tamadres_reservation_employees->count())
                        @foreach ($tamadres_reservation_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->NBRCHILDSCO }}
                                <td>{{ $value->tamadres_notes }}
                                </td>

                                <td> {{--  verify condition (if) status of tamadres_reservation==0 and  tamadres_reservations_statistic ==0
                                    to togle (show and hide) the button of delete   --}}
                                    @if ($tamadres_reservation->STATUS == 1/*  && $tamadres_reservations_statistic->STATUS == 0 */)
                                    <a href="{{ route('tamadres-reservation-cancel', ['id' => $value->tamadres_id]) }}"
                                        class="btn text-white btn-sm btn-danger">حذف منحة التمدرس</a>
                                    @endif
                                </td>

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

    <!-- Modal fade when click ADD tamadres prime in the blade-->
    <div class="modal fade " id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content " style="width: 650px">
                <div class="modal-header  text-center ">
                    <h5>
                        معلومات منحة التمدرس
                    </h5>
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
                            <input type="hidden" id="rreservationId" value="{{ $tamadres_reservation_id }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="MATRI" name="MATRI">
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" id="searchEmp" class="btn btn-sm btn-warning">إبحث</button>
                        </div>
                    </div>

                    <div class="em-info alert alert-info" id="em-info" style="display: none">
                        <div class="row">
                            <div class="col">
                                <label for="establishmentCode"> معلومات الموظف : <span id="rMATRI"></span> </label>

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
                                <label for="establishmentCode">عدد الأولاد:</label>
                                <select class="form-control" name="rnbrchild">
                                    @for ($nc = 1; $nc <= 50; $nc++)
                                        <option value="{{ $nc }}">
                                            {{ $nc }}
                                        </option>
                                    @endfor
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode">ملاحظات :</label>
                                <input type="text" class="form-control" id="rnotes" name="rnotes">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm m-1 btn-primary" style="visibility: hidden;"
                        id="addTamadres">إضافة المنحة</button>
                    <button type="button" class="btn btn-sm m-1 btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- script when click SEARCH button in modal ' to show the infos of employee by enter matri' --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to fetch establishment data
        function fetchEmployeeData(MATRI) {
            // Clear the content of all spans
            document.getElementById("rMATRI").textContent = "";
            document.getElementById("NOMA").textContent = "";
            document.getElementById("PRENOMA").textContent = "";
            document.getElementById("ADM").textContent = "";
            document.getElementById("SITFAM").textContent = "";
            document.getElementById("CATEG").textContent = "";
            document.getElementById("ECH").textContent = "";

            fetch(`/rawateb/tamadres/reservation/get-employee/${MATRI}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById("em-info-error").style.display = "none";
                    document.getElementById("em-info").style.display = "block";
                    document.getElementById("addTamadres").style.display = "block";

                    // Set the fetched data to input fields
                    document.getElementById("rMATRI").textContent = data.MATRI;
                    document.getElementById("NOMA").textContent = data.NOMA;
                    document.getElementById("PRENOMA").textContent = data.PRENOMA;
                    document.getElementById("ADM").textContent = data.ADM;
                    document.getElementById("FONCTION").textContent = data.fonction ? data.fonction
                        .LIBTABA : '';
                    document.getElementById("SITFAM").textContent = data.SITFAM;
                    document.getElementById("CATEG").textContent = data.CATEG;
                    document.getElementById("ECH").textContent = data.ECH;
                    document.getElementById("addTamadres").style.visibility = "visible";
                })
                .catch(error => {
                    document.getElementById("em-info-error").style.display = "block";
                    document.getElementById("em-info").style.display = "none";
                    document.getElementById("addTamadres").style.visibility = "hidden";
                });
        }

        // Event listener for establishment ID input
        document.getElementById("searchEmp").addEventListener("click", function() {
            var MATRI = document.getElementById("MATRI").value.trim(); // Get the entered ID
            if (MATRI) {
                // If ID is not empty, fetch establishment data
                fetchEmployeeData(MATRI);
            }
        });
    });
</script>

{{-- script when click 'اضافة المنحة' in the modal to insert the tamadres prime in th DATABASE  --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("addTamadres").addEventListener("click", function() {

            // Get input values
            var MATRI = document.getElementById("rMATRI").textContent;
            var rreservationId = document.getElementById("rreservationId").value;
            var rnbrchild = document.querySelector('select[name="rnbrchild"]').value;
            var rnotes = document.getElementById("rnotes").value;

            // Prepare data to send
            var formData = new FormData();
            formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute(
                "content"));
            formData.append("rMATRI", MATRI);
            formData.append("rreservationId", rreservationId);
            formData.append("rnbrchild", rnbrchild);
            formData.append("rnotes", rnotes);

            //alert("Rappel added succesdsqfdsqfsqd sfully!");
            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST",
            "/rawateb/tamadres/reservation/insert-tamadres"); // Replace with your backend endpoint

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("تمت إضافة المنحة بنجاح");
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
