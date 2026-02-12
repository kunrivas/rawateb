@extends('layouts.index')
{{-- linked by yield in parent view --}}
@section('title')
    طلب تحويل موظف
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">طلب تحويل موظف</a></li>
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
@endsection

{{-- chang content linked by yield in parent view --}}
@section('contents')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="mt-4">

                <!--Search input -->
                <!--adm select -->
                {{-- the form  action post of select adm in view --}}
                <form method="POST" action="{{ route('mouvement-single-employees') }}">
                    <div class="col-6 input-group mb-3">
                        <div class="col-2  text-center">الإدارة</div>
                        <select class="col-5 " name="adms_select">
                            @foreach ($adms as $key => $value)
                                <option value="{{ $value->ADM }}" @if ($adms_select == $value->ADM) selected @endif>
                                    {{ $value->LIBTABA }}</span>
                            @endforeach
                        </select>
                        <div class="col">
                            {{-- we can remplace it by @csrf after th <form> directly --}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-info">عرض</button>
                        </div>
                    </div>
                </form>
                <!--Search input -->
                {{-- the form  action post of search input in view --}}
                <form method="post" action="{{ route('mouvement-single-employees') }}">
                    @csrf
                    <div class="col-6 input-group mb-3">
                        <div class="col-2  text-center">إبحث عن</div>
                        <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                            value="{{ $search }}">
                        <button class="btn btn-info" type="submit" id="button">إبحث</button>
                    </div>
                </form>


                <table class="table table-striped mt-4 text-center" id="emptab">

                    <thead >
                        <tr>
                            <th scope="col">الرمز</th>
                            <th scope="col">الإسم</th>
                            <th scope="col">اللقب</th>
                            <th scope="col">تاريخ الميلاد</th>
                            <th scope="col">رقم الضمان الاجتماعي</th>

                            {{--  <th scope="col">رمز المؤسسة</th>
 --}}
                            <th scope="col">المؤسسة الحالية</th>

                            {{--                             <th scope="col">إسم المقتصد</th> --}}

                            <th scope="col">الرتبة</th>
                            <th scope="col">إختر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <th>{{ $employee->MATRI }}</th>
                                <td>{{ $employee->PRENOMA }}</td>
                                <td>{{ $employee->NOMA }}</td>
                                {{--  cast date nais from date time to date
                                and in the model use protected $dates = ['DATNAIS']; to
                                ignore the string import error --}}
                                @if ($employee->DATNAIS)
                                    <td>{{ $employee->DATNAIS }}</td>
                                @else
                                    <td></td>
                                @endif

                                <td>{{ $employee->NUMSS }}</td>

                                {{-- <td>{{ $employee->AFFECT }}</td> --}}
                                <td>{{ $employee->establishment->estab_ar_name ?? '/' }}</td>
                                {{--    <td>{{ $employee->establishment->estab_acc_fullname ?? '/' }}</td> --}}
                                <td>{{ $employee->fonction->LIBTABA ?? '/' }}</td>
                                <td>

                                    <div class="d-flex justify-content-center ml-2 ">
                                        <!-- Button to trigger modal -->
                                        <button class="btn text-white btn-success show-info-btn ml-2" data-toggle="modal"
                                            data-target="#infoModal"
                                            data-code="{{ $employee->establishment->estab_rawateb_user ?? '/' }}"
                                            data-name="{{ $employee->establishment->estab_ar_name ?? '/' }}"
                                            data-dirname="{{ $employee->establishment->estab_dir_fullname ?? '/' }}"
                                            data-accname="{{ $employee->establishment->estab_acc_fullname ?? '/' }}"
                                            data-fax="{{ $employee->establishment->estab_fax ?? '/' }}"
                                            data-fix="{{ $employee->establishment->estab_fix_phone ?? '/' }}"
                                            data-telacc="{{ $employee->establishment->estab_acc_mobile ?? '/' }}"
                                            data-email="{{ $employee->establishment->estab_email ?? '/' }}">معلومات
                                            المؤسسة</button>

                                        <a href="{{ route('mouvement-single-ask', ['MATRI' => $employee->MATRI]) }}"
                                            class="btn text-white btn-primary  ml-2">طلب تحويل الموظف </a>

                                    </div>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>

                </table>
                {{-- to link table by pagination  --}}
                @if ($employees->count()>0)
                {{ $employees->links() }}

                @endif
                {{--   in service provider add
                   use Illuminate\Pagination\Paginator;

                   public function boot()
                   {
                   Paginator::useBootstrap();
                   }
                   because the Paginator class is responsible for paginating data.
                   By default, it uses a simple default style for pagination links.
                    However, if you're using a front-end framework like Bootstrap,
                    you must add it --}}

            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- <div class="modal fade" id="infoModal" tabindex="-1" style="margin-top: 50px;" role="dialog" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel"> معلومات المؤسسة :</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>رمز المؤسسة:</strong> <span id="establishmentCode"></span></p>
                    <p><strong>إسم المؤسسة:</strong> <span id="establishmentName"></span></p>
                    <p><strong>إسم المدير:</strong> <span id="establishmentDir"></span></p>
                    <p><strong>إسم المقتصد:</strong> <span id="establishmentAcc"></span></p>
                    <p><strong>رقم الفاكس:</strong> <span id="establishmentFax"></span></p>
                    <p><strong>رقم هاتف المؤسسة:</strong> <span id="establishmentFix"></span></p>
                    <p><strong>رقم هاتف المقتصد:</strong> <span id="establishmentAccTel"></span></p>
                    <p><strong>إيمايل المؤسسة:</strong> <span id="establishmentEmail"></span></p>
                </div>
            </div>
        </div>
    </div>
     --}}
    <!-- Button trigger modal -->
    < <!-- Modal -->


        <!-- Modal -->
        <div class="modal fade" id="infoModal" style="margin-top: 50px;" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-center ">
                        <h5>
                            معلومات المؤسسة
                        </h5>
                         <button type="button" class="close" style="margin-left: 0px;" data-dismiss="modal"
                            aria-label="Close">
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

        <script>
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
