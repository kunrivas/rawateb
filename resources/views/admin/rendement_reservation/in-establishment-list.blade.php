@extends('layouts.admin')
@section('title')
    تسير حجز المردودية
@endsection
@section('content-title')
    <h1> قائمة المؤسسات التي لم تحجز </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
    <li class="breadcrumb-item"><a href="#"> تسير حجز المردودية</a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }
    </style>
@endsection

@section('contents')
    <form method="post" action="{{ route('admin-rendements-in-establishments', $rendement_reservations_id) }}">
        @csrf
        <div class="col-6 input-group mb-3 row">
            {{--  label search --}}
            <div class="col-2  text-center">إبحث عن</div>

            <div class="col-8" style="position: relative">
                {{--  input search --}}
                <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                    value="{{ $search }}">
                {{-- dropdown filter --}}

            </div>

            <button class="btn btn-info col-2 btn-sm" type="submit" id="button">إبحث</button>
        </div>
    </form>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الرمز</th>
                        <th scope="col">إسم المؤسسة</th>

                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($establishments as $establishment)
                        <tr>


                            <td>
                                {{ $establishment->estab_rawateb_user }}
                            </td>
                            <td>
                                {{ $establishment->estab_ar_name }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center ml-2 ">
                                    <!-- Button to trigger modal -->
                                    <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal"
                                        data-target="#infoModal" data-code="{{ $establishment->estab_rawateb_user ?? '/' }}"
                                        data-name="{{ $establishment->estab_ar_name ?? '/' }}"
                                        data-dirname="{{ $establishment->estab_dir_fullname ?? '/' }}"
                                        data-accname="{{ $establishment->estab_acc_fullname ?? '/' }}"
                                        data-fax="{{ $establishment->estab_fax ?? '/' }}"
                                        data-fix="{{ $establishment->estab_fix_phone ?? '/' }}"
                                        data-telacc="{{ $establishment->estab_acc_mobile ?? '/' }}"
                                        data-email="{{ $establishment->estab_email ?? '/' }}">معلومات
                                        المؤسسة</button>



                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $establishments->appends(request()->input())->links() }}

        </div>
    </div>
    <div class="modal fade" id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-center ">
                    <h5>
                        معلومات المؤسسة
                    </h5>
                    <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>رمز المؤسسة : </strong> <span id="establishmentCode"></span></p>
                    <p><strong>إسم المؤسسة : </strong> <span id="establishmentName"></span></p>
                    <p><strong>إسم المدير : </strong> <span id="establishmentDir"></span></p>
                    <p><strong>إسم المقتصد : </strong> <span id="establishmentAcc"></span></p>
                    <p><strong>رقم الفاكس : </strong> <span id="establishmentFax"></span></p>
                    <p><strong>رقم هاتف المؤسسة : </strong> <span id="establishmentFix"></span></p>
                    <p><strong>رقم هاتف المقتصد : </strong> <span id="establishmentAccTel"></span></p>
                    <p><strong>إيمايل المؤسسة : </strong> <span id="establishmentEmail"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            var showInfoButtons = document.querySelectorAll(".show-info-btn");

            showInfoButtons.forEach(function(button) {
                button.addEventListener("click", function() {

                    var modal = document.getElementById("infoModal");
                    var code = button.getAttribute("data-code");
                    var name = button.getAttribute("data-name");
                    var dirname = button.getAttribute("data-dirname");
                    var accname = button.getAttribute("data-accname");
                    var fax = button.getAttribute("data-fax");
                    var fix = button.getAttribute("data-fix");
                    var telacc = button.getAttribute("data-telacc");
                    var email = button.getAttribute("data-email");

                    // Set modal content with establishment info


                    modal.querySelector("#establishmentCode").textContent = code;
                    modal.querySelector("#establishmentName").textContent = name;
                    modal.querySelector("#establishmentDir").textContent = dirname;
                    modal.querySelector("#establishmentAcc").textContent = accname;
                    modal.querySelector("#establishmentFax").textContent = fax;
                    modal.querySelector("#establishmentFix").textContent = fix;
                    modal.querySelector("#establishmentAccTel").textContent = telacc;
                    modal.querySelector("#establishmentEmail").textContent = email;

                });
            });
        });
    </script>
@endsection
