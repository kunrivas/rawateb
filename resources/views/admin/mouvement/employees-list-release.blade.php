@extends('layouts.admin')
{{-- linked by yield in parent view --}}
@section('title')
    قائمة الموظفين المحررين
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين المحررين </a></li>
@endsection
@section('css')
    <style>
        .form-check {
            padding-top: 5px;
            font-size: 12.5px;
        }
    </style>
@endsection
{{-- chang content linked by yield in parent view --}}
@section('contents')
    <div class="row">
        <div class="col">
            <div class="mt-4">

                <form method="post" action="{{ route('admin-mouvement-employees-list-release') }}">
                    @csrf
                    <div class="col-6 input-group mb-3 row">
                        <div class="col-2  text-center">إبحث عن</div>
                        <div class="col-8" style="position: relative">
                            <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                                value="{{ $search }}">
                            <div class="dropdown" style="position: absolute;top:0;left:9px">
                                <button class="btn  " type="button" data-toggle="dropdown"
                                    style="background: transparent; height: 34px;          border-right: 1px solid #ced4da;
                                                                        ">
                                    <i class="fa fa-filter"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right  " style="width: 500px;padding: 10px;">
                                    <div class="row">
                                        <div class="col">
                                            <h5 style="text-align: right">الحالة</h5>
                                            <div>
                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="checkbox" name="sitpai[0]"
                                                        id="flexCheckIndeterminate" {{-- condition if this stutus (1) is in select_status array make it checked --}}
                                                        @if (in_array(0, $select_sitpai)) checked @endif>
                                                    {{-- checkbox label of affichage --}}
                                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                                        في حالة نشاط
                                                    </label>
                                                </div>

                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="checkbox" name="sitpai[1]"
                                                        id="flexCheckIndeterminate"
                                                        @if (in_array(1, $select_sitpai)) checked @endif>
                                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                                      خارج الخدمة
                                                    </label>
                                                </div>
                                            </div>
                                                </div>
                                        <div class="col-6" style="border-right: 0.5px solid #dfd9d9;padding-right: 10px;">
                                            <h5 style="text-align: right">الادارة</h5>
                                            <div>
                                                @foreach ($adms as $adm)
                                                    @if ($adm->ADM != '0')
                                                        <div class="form-check d-flex">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="adms[{{ $adm->ADM }}]"
                                                                @if (in_array($adm->ADM, $select_adms)) checked @endif
                                                                id="flexCheckIndeterminate">
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
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

                <table class="table table-striped mt-4" id="emptab">

                    <thead>
                        <tr>
                            <th scope="col">الرمز</th>
                            <th scope="col">الإسم</th>
                            <th scope="col">اللقب</th>
                            <th scope="col">تاريخ الميلاد</th>
                            <th scope="col">رقم الضمان الاجتماعي</th>
                            <th scope="col">الحالة</th>
                            <th scope="col"> </th>
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
                                <td>
                                    @switch($employee->SITPAI)
                                        @case(1)
                                            في الخدمة
                                        @break

                                        @case(2)
                                            متقاعد
                                        @break

                                        @case(3)
                                            خارج القطاع
                                        @break

                                        @case(4)
                                            إستيداع
                                        @break

                                        @case(5)
                                            متوفي
                                        @break
                                    @endswitch
                                </td>
                                <td>

                                    
                                </td>

                            </tr>
                        @endforeach


                    </tbody>

                </table>
                {{-- to link table by pagination  --}}
                {{--  {{ $employees->links() }} --}}
                {{-- to link table by pagination with selected values like select adms select status  --}}
                {{ $employees->appends(request()->input())->links() }}

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


    {{-- @push('scripts')
        <script>
            < $(document).ready(function() {
                var table = $('.emptab').DataTable();

                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });

            });
        </script>
    @endpush --}}
@endsection
