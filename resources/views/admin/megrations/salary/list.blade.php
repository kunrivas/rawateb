@extends('layouts.admin')
@section('title')
    تسير الحزم الاجر الشهري
@endsection
@section('content-title')
    <h1> تسير الحزم الاجر الشهري </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">الاجر الشهري</a></li>
    <li class="breadcrumb-item"><a href="#"> تسير الحزم</a></li>
@endsection
@section('contents')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row mb-2">
        <div class="col"></div>
        <div class="col-2">
            <a class="btn btn-success " href="{{ route('admin-megration-salary-create') }}">إضافة حزمة جديدة</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">السنة</th>
                        <th scope="col">الشهر</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($megrations as $megration)
                        <tr>
                            <td>
                                {{ Mlibrary::getArabicMonth($megration->MONTH) }}
                            </td>
                            <td>
                                {{ $megration->YEAR }}
                            </td>
                            <td>
                                @if ($megration->STATUS == 0)
                                    @if ($megration->RUN == 0)
                                        <span class="badge badge-danger" style="font-size: 13px;    padding: 7px;">لم يتم
                                            التنفيذ</span>
                                    @else
                                        <span class="badge  badge-warning" style="font-size: 13px;    padding: 7px;">يتم
                                            التنفيذ</span>
                                    @endif
                                @else
                                    <span class="badge  badge-success" style="font-size: 13px;    padding: 7px;">تم
                                        التنفيذ</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                        {{-- @if ($megration->STATUS == 1) disabled @endif --}}>العمليات</button>
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false" {{--   @if ($megration->STATUS == 1) disabled @endif --}}> <span
                                            class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        @if ($megration->STATUS == 0)
                                            <form action="{{ route('admin-megration-salary-run') }}" method="post"
                                                id="megrationForm">
                                                @csrf
                                                <input type="hidden" name="ID_MEGRATION"
                                                    value="{{ $megration->ID_MEGRATION }}">
                                                <button type="submit" id="submitBtn"
                                                    class="dropdown-item text-success font-weight-bold"
                                                    href="#">تنفيذ</button>
                                            </form>
                                            {{--   <button type="button" class="btn-run dropdown-item text-success font-weight-bold" megration="{{ $megration->ID_MEGRATION }}">تنفيذ</button>

                                           --}}
                                            <form action="{{ route('admin-megration-salary-delete') }}" method="post"
                                                onsubmit="return confirm('هل أنت متأكد من أنك تريد حذف هذا الشهر؟');">
                                                @csrf
                                                <input type="hidden" name="ID_MEGRATION"
                                                    value="{{ $megration->ID_MEGRATION }}">
                                                <button type="submit" class="dropdown-item text-danger font-weight-bold"
                                                    href="#">حذف</button>
                                            </form>
                                        @else
                                           
                                            <button class="dropdown-item show-info-btn ml-2"
                                                data-id="{{ $megration->ID_MEGRATION }}">
                                                إحصائيات الحزمة </button>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin-megration-salary-delete') }}" method="post"
                                                onsubmit="return confirm('هل أنت متأكد من أنك تريد حذف هذا الشهر؟');">
                                                @csrf
                                                <input type="hidden" name="ID_MEGRATION"
                                                    value="{{ $megration->ID_MEGRATION }}">
                                                <button type="submit" class="dropdown-item text-danger font-weight-bold"
                                                    href="#">حذف</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $megrations->links() }}
        </div>
    </div>
    <!-- Modal HTML -->
    <div class="modal fade " id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-center d-flex justify-content-center">
                    <h5 class="text-white  ">
                        الرجاء الإنتظار
                    </h5>
                </div>
                <div class="modal-body text-center">
                    <h5 class="opacity-motion">
                        يتم حاليا رفع الملف </h5>
                    {{-- <button class="btn btn-primary" type="button" disabled>
                        <marquee style="" width="100%" direction="left" behavior="scroll" scrollamount="12">Very Fast
                            Scrolling</marquee> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-center ">
                    <h5>
                        معلومات الحزمة
                    </h5>
                    <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>رمز الحزمة : </strong> <span id="ID_MEGRATION"></span></p>
                    <p><strong>شهر الحزمة : </strong> <span id="MONTH"></span></p>
                    <p><strong>سنة الحزمة : </strong> <span id="YEAR"></span></p>
                    <p><strong>عنوان الحزمة : </strong> <span id="LOT"></span></p>
                    <p><strong>عدد المستخدمين : </strong> <span id="nbr_employees"></span></p>
                    <p><strong>الصافي الإجمالي : </strong> <span id="total_NETPAI"></span></p>
                    <p><strong>الخام الإجمالي : </strong> <span id="total_TOTGAIN"></span></p>
                    <p><strong>اقتطاع الضمان الاجتماعي الإجمالي : </strong> <span id="total_RETSS"></span></p>
                    <p><strong>اقتطاع الاشتراكات الإجمالي: </strong> <span id="total_PARTSS"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes opacityMotion {
            0% {
                /*  transform: translateX(50%);  */
                opacity: 0;
            }

            100% {
                /*    transform: translateX(-50%);  */
                opacity: 1;
            }
        }

        .opacity-motion {
            display: inline-block;
            animation: opacityMotion 1s linear infinite;
            white-space: nowrap;
        }
    </style>

@endsection
@section('js')
    <script>
        $(document).on('click', '.show-info-btn', function() {
            const ID_MEGRATION = $(this).data('id'); // Fetch the ID_MEGRATION from the button

            $.ajax({
                url: `/rawateb/manager/megration/salary/${ID_MEGRATION}/stat`, // Use the route
                method: 'GET',
                success: function(data) {
                    // Populate the modal fields with the data
                    $('#infoModal #ID_MEGRATION').text(data.ID_MEGRATION);
                    $('#infoModal #MONTH').text(data.MONTH);
                    $('#infoModal #YEAR').text(data.YEAR);
                    $('#infoModal #LOT').text(data.LOT);
                    $('#infoModal #nbr_employees').text(data.nbr_employees);
                    $('#infoModal #total_NETPAI').text(data.total_NETPAI);
                    $('#infoModal #total_TOTGAIN').text(data.total_TOTGAIN);
                    $('#infoModal #total_RETSS').text(data.total_RETSS);
                    $('#infoModal #total_PARTSS').text(data.total_PARTSS);

                    // Show the modal
                    $('#infoModal').modal('show');
                },
                error: function() {
                    alert('Error fetching data. Please try again.');
                }
            });
        });
    </script>

    {{--  script of waiting spinner modal --}}
    <script>
        //$('#loadingModal').modal('show');
        document.getElementById('megrationForm').addEventListener('submit', function(event) {
            // Show the loading modal
            $('#loadingModal').modal('show');
        });
    </script>

    {{-- script of run with ajax --}}
    {{--  <script defer>
        $(".btn-run").click(function(evt) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            megration = $(this).attr("megration");
            data = [];
            data["ID_MEGRATION"] = megration;
            data["_token"] = _token;
            console.log(data);

            $.ajax({
                type: 'POST',
                url: "{{ route('admin-megration-salary-run') }}",
                data: {
                    ID_MEGRATION: megration,
                    _token: _token
                },
            });
            //$(this).attr('disabled', 'disabled');
            setTimeout(() => {
                location.reload();
            }, 5000);

        });
    </script> --}}
@endsection
