@extends('layouts.index')
@section('title')
    حجز المخلفات
@endsection
@section('content-title')
    <h1> حجز المخلفات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المخلفات </a></li>
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

    @if ($rapeelReservation->STATUS == 1)
        <div class="d-flex flex-row-reverse bd-highlight">
            <!-- Button to trigger modal -->
            <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal" data-target="#infoModal">إضافة
                مخلف</button>
        </div>
    @endif

    {{-- add rappel reservation employee --}}


    {{-- table rappel reservation employees --}}
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
                        <th scope="col">نوع المخلف</th>
                        <th scope="col">قيمة المخلف</th>
                        <th scope="col">تاريخ السريان</th>
                        @if ($rapeelReservation->STATUS != 1)
                            <th scope="col"> العمليات</th>
                        @endif

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($rappel_reservations_employees))
                        @foreach ($rappel_reservations_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ Mlibrary::getRappelType($value->rappel_type) ?? '' }}</td>
                                <td>{{ $value->rappel_val ?? '' }}</td>
                                <td>{{ $value->rappel_date ?? '' }}</td>
                                @if ($rapeelReservation->STATUS == 1)
                                    <td>
                                        <div class="d-flex justify-content-center ml-2 ">
                                            {{--     <a href="{{ route('salary-single-list', ['id' => $value->id]) }}"
                                        class="btn text-white btn-primary  ml-2">تعديل المخلف</a> --}}
                                            <a href="{{ route('rappel-reservation-cancel', ['id' => $value->rappel_id]) }}"
                                                class="btn text-white btn-sm btn-danger">حذف المخلف</a>
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
                        معلومات المخلف
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
                            <input type="hidden" id="rreservationId" value="{{ $rappel_reservation_id }}">
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
                                <label for="establishmentCode">  معلومات الموظف : <span id="rMATRI"></span> </label>

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
                                <label for="establishmentCode">نوع الخلف:</label>
                                <select class="form-control" name="rtype">
                                    @for ($type = 1; $type <= 7; $type++)
                                        <option value="{{ $type }}">
                                            {{ Mlibrary::getRappelType($type) }}
                                        </option>
                                    @endfor
                                </select>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode">قيمة المخلف:</label>
                                <input type="text" class="form-control" id="rvalue" name="rvalue">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col ">

                            <div class="form-group">
                                <label for="establishmentCode">تاريخ السريان:</label>
                                <input type="date" class="form-control" id="rdate" name="rdate">

                            </div>
                        </div>
                        <div class="col">

                            <div class="form-group">
                                <label for="establishmentCode">الملاحظات:</label>
                                <input type="text" class="form-control" id="rnotes" name="rnotes">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm m-1 btn-primary" style="visibility: hidden;" id="addRappel">إضافة المخلف</button>
                    <button type="button" class="btn btn-sm m-1 btn-secondary"  data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

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

                fetch(`/rawateb/rappel/reservation/get-employee/${MATRI}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById("em-info-error").style.display = "none";
                        document.getElementById("em-info").style.display = "block";
                        document.getElementById("addRappel").style.display = "block";

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
                        document.getElementById("addRappel").style.visibility = "visible";
                    })
                    .catch(error => {
                        document.getElementById("em-info-error").style.display = "block";
                        document.getElementById("em-info").style.display = "none";
                        document.getElementById("addRappel").style.visibility = "hidden";
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("addRappel").addEventListener("click", function() {

                // Get input values
                var MATRI = document.getElementById("rMATRI").textContent;
                var rreservationId = document.getElementById("rreservationId").value;
                var rtype = document.querySelector('select[name="rtype"]').value;
                var rvalue = document.getElementById("rvalue").value;
                var rdate = document.getElementById("rdate").value;
                var rnotes = document.getElementById("rnotes").value;
                //alert(MATRI+rtype+rvalue+rdate+rnotes);

                // var csrfToken = updateCsrfToken();

                // Prepare data to send
                var formData = new FormData();
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute(
                    "content"));
                formData.append("rMATRI", MATRI);
                formData.append("rreservationId", rreservationId);
                formData.append("rtype", rtype);
                formData.append("rvalue", rvalue);
                formData.append("rdate", rdate);
                formData.append("rnotes", rnotes);

                //alert("Rappel added succesdsqfdsqfsqd sfully!");
                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/rawateb/rappel/reservation/insert-rappel"); // Replace with your backend endpoint

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert("تمت إضافة المخلف بنجاح");
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addRappel').click(function() {
                // Get input values
                var MATRI = $('#MATRI').val();
                var type = $('select[name="rappel_type"]').val();
                var value = $('#rappel_value').val();
                var date = $('#rappel_date').val();
                var notes = $('#rappel_notes').val();

                // Prepare data to send
                var formData = {
                    _token: $('meta[name="csrf-token"]').attr(
                    'content'), // Access CSRF token from meta tag
                    MATRI: MATRI,
                    type: type,
                    value: value,
                    date: date,
                    notes: notes
                };

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '/insert-rappel', // Replace with your backend endpoint
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        alert('Rappel added successfully!');
                        // Optionally, you can close the modal or do any other action here
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('Error adding rappel: ' + error);
                    }
                });
            });
        });
    </script> --}}

@endsection
{{-- @section('js')
    <script defer>
        $(document).ready(function() {

            $("#saveForem").submit(function(e) {

                //stop submitting the form to see the disabled button effect
                //  e.preventDefault();

                //disable the submit button
                $("#save-btn").attr("disabled", true);

                //disable a normal button
                $("#save-btn").attr("disabled", true);

                return true;

            });
            $("#fitAll").click(function(e) {
                e.preventDefault();

                $('div input[max-point]').each(function() {
                    $(this).attr('value', $(this).attr('max-point'));
                });

                return true;

            });
        });
    </script>
@endsection --}}
