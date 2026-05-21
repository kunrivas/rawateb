@extends('layouts.director')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    <h1> حجز المردودية </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
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
    {{-- Cards of statistics --}}
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الموظفين</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->total ?? 0 }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين تم حجزهم</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->reserved }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد من لديهم نقطة 0</span>
                    <span class="info-box-number">{{ $rendement_reservations_statistic->ziroPoint }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa  fa-line-chart "></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">عدد الذين لم يحجزوا</span>
                    <span
                        class="info-box-number">{{ $rendement_reservations_statistic->total - $rendement_reservations_statistic->reserved }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Form for search and filter --}}
    <form method="post" action="{{ route('director-rendements-reservation-employee-list', $rendementReservation->id) }}">
        @csrf
        <div class="col-6 input-group mb-3 row">
            <div class="col-2 text-center">إبحث عن</div>
            <div class="col-8" style="position: relative">
                <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                    value="{{ $search }}">
                <div class="dropdown" style="position: absolute;top:0;left:9px">
                    <button class="btn" type="button" data-toggle="dropdown"
                        style="background: transparent; height: 34px; border-right: 1px solid #ced4da;">
                        <i class="fa fa-filter"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                        style="width: 300px;padding: 10px; border: 1px solid gray;">
                        <div class="row">
                            <div class="col" style="border-right: 0.5px solid #dfd9d9;padding-right: 10px;">
                                <h5 style="text-align: right">الادارة</h5>
                                <div>
                                    @foreach ($adms as $adm)
                                        @if ($adm->ADM != '0')
                                            <div class="form-check d-flex">
                                                <input class="form-check-input" type="checkbox"
                                                    name="adms[{{ $adm->ADM }}]"
                                                    @if (in_array($adm->ADM, $select_adms)) checked @endif
                                                    id="flexCheckIndeterminate{{ $adm->ADM }}">
                                                <label class="form-check-label"
                                                    for="flexCheckIndeterminate{{ $adm->ADM }}">
                                                    {{ $adm->LIBTABA }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
        </div>
    </form>

    {{--  @if ($rendementReservation->status && $rendement_reservations_statistic->status == 0) --}}
    @if ($rendementReservation->status)
        <div class="d-flex flex-row-reverse bd-highlight">
            <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal" data-target="#infoModal">إضافة
                موظف</button>
        </div>
    @endif
    {{--  @endif --}}

    <div class="row">
        <div class="col">
            @csrf
            <input type="hidden" name="rendement_reservations_id" value="{{ $rendementReservation->id }}">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col"> عدد ايام الغياب </th>
                        <th scope="col">نقطة المردودية </th>
                        <th scope="col"> </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($rendement_reservations_employees) && $rendement_reservations_employees->count())
                        @foreach ($rendement_reservations_employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else class="saved" @endif @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->abs }}</td>
                                <td>
                                    {{ $value->point }}
                                    @if ($value->employee->fonction)
                                        / {{ intval($value->employee->fonction->TAUXPR ?? '') }}
                                    @endif
                                </td>
                                <td>
                                    {{--  @if ($rendementReservation->status && $rendement_reservations_statistic->status == 0) --}}
                                    @if ($rendementReservation->status)
                                        <a class="btn btn-danger btn-sm"
                                            href="{{ route('director-rendements-reservation-employee-delete', ['rendement_reservations_id' => $rendementReservation->id, 'MATRI' => $value->MATRI]) }}">حذف</a>
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

    <!-- Modal -->
    <div class="modal fade" id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 650px">
                <div class="modal-header text-center">
                    <h5>معلومات الموظف</h5>
                    <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal"
                        aria-label="Close">
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
                            <input type="hidden" id="rreservationId" value="">
                            <div class="form-group">
                                <input type="text" class="form-control" id="MATRI" name="MATRI">
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" id="searchEmp" class="btn btn-sm btn-warning">إبحث</button>
                        </div>
                    </div>

                    <div class="em-info alert" id="em-info" style="display: none; background: #ffc10740;">
                        <div class="row">
                            <div class="col">
                                <label for="establishmentCode"> معلومات الموظف : <span id="MATRI_display"></span> </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mr-3"><strong>الإسم الكامل : </strong> <span id="NOMA"></span> <span
                                        id="PRENOMA"></span></p>
                            </div>
                            <div class="col">
                                <p class="mr-3"><strong>الإدارة : </strong> <span id="ADM"></span></p>
                            </div>
                            <div class="col">
                                <p class="mr-3"><strong>الحالة العائلية : </strong> <span id="SITFAM"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mr-3"><strong>الوظيفة : </strong> <span id="FONCTION"></span></p>
                            </div>
                            <div class="col">
                                <p class="mr-3"><strong>الصنف : </strong> <span id="CATEG"></span></p>
                            </div>
                            <div class="col">
                                <p class="mr-3"><strong>الدرجة : </strong> <span id="ECH"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mr-3"><strong>المؤسسة العمل : </strong> <span id="estab"></span></p>
                            </div>
                      <div class="col">
                                <p class="mr-3"><strong>عدد ايام الغياب : </strong> <span id="abs"></span></p>
                            </div> 
                        </div>
                    </div>

                    <div class="alert alert-danger" id="em-info-error" style="display: none">
                        الموظف غير موجود
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode"> النقطة:</label>
                                <input type="number" class="form-control" id="point" name="point">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="establishmentCode">العلامة القصوى:</label>
                                <input type="number" class="form-control" disabled id="maxpoint" name="maxpoint">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm m-1 btn-primary" style="display: none;" id="addBtn">حجز
                        النقطة</button>
                    <button type="button" class="btn btn-sm m-1 btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        let maxpoint = 40;
        $(document).ready(function() {

            function fetchEmployeeData(MATRI) {
                $("#MATRI_display, #NOMA, #PRENOMA, #ADM, #SITFAM, #CATEG, #ECH").text("");
                $("#em-info-error").hide();
                $("#em-info").hide();
                $("#addBtn").hide();

                $.ajax({
                    url: `/director/rendement/{{ $rendementReservation->id }}/get-employee/${MATRI}`,
                    type: 'GET',
                    success: function(data) {
                        if (data) {
                            $("#em-info-error").hide();
                            $("#em-info").show();
                            $("#MATRI_display").text(data.MATRI);
                            $("#NOMA").text(data.NOMA);
                            $("#PRENOMA").text(data.PRENOMA);
                            $("#ADM").text(data.ADM);
                            $("#FONCTION").text(data.fonction ? data.fonction.LIBTABA : '');
                            $("#SITFAM").text(data.SITFAM);
                            $("#CATEG").text(data.CATEG);
                            $("#ECH").text(data.ECH);
                             $("#abs").text(data.abs); 
                            if (data.fonction) {
                                $("#maxpoint").val(data.fonction.TAUXPR);
                                maxpoint = parseInt(data.fonction.TAUXPR);
                            }
                            $("#estab").text(data.establishment ? data.establishment.estab_ar_name :
                                "لا ينتمي لاي مؤسسة");
                            $("#addBtn").show();
                        }
                    },
                    error: function() {
                        $("#em-info-error").show();
                        $("#em-info").hide();
                        $("#addBtn").hide();
                    }
                });
            }

            $("#searchEmp").on("click", function() {
                var MATRI = $("#MATRI").val().trim();
                if (MATRI) fetchEmployeeData(MATRI);
            });

            $("#addBtn").click(function(e) {
                e.preventDefault();
                $("#addBtn").hide();
                var MATRI = $("#MATRI_display").text();
                var areservationId = {{ $rendementReservation->id }};
                var point = parseInt($("#point").val());
                if (point && (point > maxpoint || point < 0)) {
                    alert("النقطة لا يجب ان تكون اعلى من " + maxpoint + " أو اقل من 0");
                    $("#addBtn").show();
                    return;
                }

                var formData = new FormData();
                formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
                formData.append("MATRI", MATRI);
                formData.append("rendement_reservations_id", areservationId);
                formData.append("point", point);

                $.ajax({
                    url: "/director/rendement/reservation/employee/add",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 0) {
                            alert(response.message);
                            $("#addBtn").show();
                        } else if (response.status === 1) {
                            alert("تم إضافة بنجاح");
                            $("#infoModal").modal('hide');
                            location.reload();
                        }
                    },
                    error: function() {
                        alert("هناك خطأ");
                    }
                });
            });

            window.onClickType = function(type) {
                $("[id^='btn-type-']").removeClass('btn-success').addClass('btn-light');
                $(`#btn-type-${type}`).removeClass('btn-light').addClass('btn-success');
                atype = type;
            };
        });
    </script>
@endsection
