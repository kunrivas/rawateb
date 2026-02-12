

@extends('layouts.director')
@section('title')
    @if ($dir_absence_reservation->Type == 0)
        حجز الغيابات لشهر {{ Mlibrary::getArabicMonth($dir_absence_reservation->MONTH) }} سنة
            {{ $dir_absence_reservation->YEAR }}
    @else
        <h1>حجز الاضراب لشهر {{ Mlibrary::getArabicMonth($dir_absence_reservation->MONTH) }} سنة
            {{ $dir_absence_reservation->YEAR }}</h1>
    @endif
@endsection
@section('content-title')
    @if ($dir_absence_reservation->Type == 0)
        <h1>حجز الغيابات لشهر {{ Mlibrary::getArabicMonth($dir_absence_reservation->MONTH) }} سنة
            {{ $dir_absence_reservation->YEAR }}</h1>
    @else
        <h1>حجز الاضراب لشهر {{ Mlibrary::getArabicMonth($dir_absence_reservation->MONTH) }} سنة
            {{ $dir_absence_reservation->YEAR }}</h1>
    @endif
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

    @if ($dir_absence_reservation->STATUS == 1)
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
                        <th scope="col">الحالة</th>
                        @if ($dir_absence_reservation->STATUS != 0)
                            <th scope="col"> العمليات</th>
                        @endif

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($dir_absence_reservation_employees))
                        @foreach ($dir_absence_reservation_employees as $key => $value)
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
                                @if ($value->ACTIVE == 1)
                                    <td style=""> <span class="badge badge-success p-2">تم تأكيد الغياب</span></td>
                                @else
                                    <td style=""> <span class="badge badge-danger p-2">لم يتم تأكيد الغياب</span></td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-center ml-2 ">

                                        @if ($dir_absence_reservation->STATUS == 1)
                                            @if ($value->ACTIVE == 0)
                                                <a href="{{ route('director-absence-reservation-cancel', ['id' => $value->absence_id]) }}"
                                                    class="btn text-white btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الغياب؟');">
                                                    حذف الغياب
                                                </a>
                                            @endif
                                        @endif

                                        <a href="{{ route('director-absence-single-print', ['id' => $value->absence_id]) }}" target="_blank"
                                            class="btn text-white btn-sm btn-primary">
                                            طباعة الإشعار بالخصم </a>
                                    </div>
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
                            <input type="hidden" id="areservationId" value="{{ $dir_absence_reservation_id }}">
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
                    @if ($dir_absence_reservation->Type == 0)
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

                    <div class="row">
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



@endsection
@section('js')
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


                fetch(`/rawateb/director/absence/reservation/get-employee/${MATRI}`)
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
        let atype = -1;
        let anbrdays = -1;
        $(document).ready(function() {

            $('.abs-date').on('input', function() {
                if ($('#adayfrom').val() != '' && $('#adayto').val() != '') {
                    dif_in_mis = new Date($('#adayto').val()) - new Date($('#adayfrom').val());
                    dif_in_ho = ((dif_in_mis / 1000) / 60) / 60 / 24;
                    dif_in_ho += 1;
                    if (dif_in_ho > 0) {
                        $('#number-abs').text(dif_in_ho);
                        anbrdays = dif_in_ho;
                        $('#number-abs').attr("style", "color:green;text-align: center;");
                    } else {
                        $('#number-abs').text("خطأ في كتابة التواريخ");
                        $('#number-abs').attr("style", "color:red;text-align: center;");
                    }
                }
            });


            $("#addabsence").click(function() {

                var MATRI = $("#aMATRI").text();
                var areservationId = $("#areservationId").val();
                var adayfrom = $("#adayfrom").val();
                var adayto = $("#adayto").val();

                // Prepare data to send
                var formData = new FormData();
                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
                formData.append("aMATRI", MATRI);
                formData.append("areservationId", areservationId);
                formData.append("atype", atype);
                formData.append("anbrdays", anbrdays);
                formData.append("adayfrom", adayfrom);
                formData.append("adayto", adayto);

                // Send AJAX request
                $.ajax({
                    url: "/rawateb/director/absence/reservation/insert-absence",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response[0] === "deplicated") {
                            var alertMessage =
                                "لديك تكرار الرجاء التأكد من التواريخ التالية:\n";

                            response[1].forEach(function(absence) {
                                alertMessage +=
                                    "\من: " + absence.DAY_FROM +
                                    " إلى: " + absence.DAY_TO +
                                    "\nعدد الايام: " + absence.NBR_DAYS +
                                    "\n\n";
                            });
                            alert(alertMessage);
                        } else if (response[0] === "add") {
                            alert("تم إضافة بنجاح");
                            var modal = $("#infoModal");
                            modal.removeClass("show").hide().attr("aria-hidden", "true");
                            window.location.reload();
                        } else if (response[0] === "plus") {

                            var alertMessage =
                                "  الرجاء التأكد من عدد الايام أصبح يفوق 30  :\n";
                            alertMessage += "عدد الايام : " + response[1]
                            alert(alertMessage);
                        }
                    },
                    error: function() {
                        alert("هناك خطأ");
                    }
                });
            });
        });

        function onClickType(type) {
            // Get all buttons that match the type pattern
            const buttons = document.querySelectorAll('[id^="btn-type-"]');

            // Reset all buttons to btn-light
            buttons.forEach(button => {
                button.classList.remove('btn-success');
                button.classList.add('btn-light');
            });
            atype = type;
            // Set the clicked button to btn-success
            const clickedButton = document.getElementById(`btn-type-${type}`);
            clickedButton.classList.remove('btn-light');
            clickedButton.classList.add('btn-success');
        }
    </script>
@endsection
