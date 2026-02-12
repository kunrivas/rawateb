@extends('layouts.absence')
@section('title')
    تأكيد الغيابات
@endsection
@section('content-title')
    <h1> تأكيد الغيابات
    </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">تأكيد الغيابات </a></li>
@endsection

@section('contents')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{--  search form  --}}
    <form method="post" action="{{ route('post-absence-validation') }}">
        @csrf
        <div class="col-6 input-group mb-3 row">
            {{--  label search --}}
            <div class="col-2  text-center">إبحث بالباركود</div>

            <div class="col-8" style="position: relative">
                {{--  input search --}}
                <input type="text" class="form-control" id="search" name="barcode" placeholder="ادخل الباركود"
                    value="">

            </div>

            <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
        </div>
    </form>




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


                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

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


                fetch(`/rawateb/absence/reservation/get-employee/${MATRI}`)
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
    <script></script>
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
                    url: "/rawateb/absence/reservation/insert-absence",
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
