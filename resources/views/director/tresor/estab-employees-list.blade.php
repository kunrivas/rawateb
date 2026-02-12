@extends('layouts.director')
{{-- linked by yield in parent view --}}
@section('title')
  مراسلة الخزينة
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
    <li class="breadcrumb-item"><a href="#">تسير الموظفين</a></li>
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
       {{--      <a href="{{ route('director-tresor-print') }}" class="btn btn-success col-2 ml-2" target="_blank">
                <i class="fa fa-print"></i> طباعة القائمة الإجمالية
            </a> --}}
            <div class="mt-4">

        

                <table class="table table-striped mt-4" id="emptab">

                    <thead>
                        <tr>
                            <th scope="col">الرمز</th>
                            <th scope="col">الإسم</th>
                            <th scope="col">اللقب</th>
                            <th scope="col">رقم الضمان الاجتماعي</th>
                            <th scope="col">تاريخ الميلاد</th>

                            {{--  <th scope="col">Nom et Prenom</th> --}}
                            <th scope="col"> رقم التعريف الوطني (NIN)</th>
                           
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
                                <th>{{ $employee->NUMSS }}</th>
                                @if ($employee->DATNAIS)
                                    <td>{{ $employee->DATNAIS }}</td>
                                @else
                                    <td></td>
                                @endif

                                {{--        <td>{{ $employee->NOMPRENOM }}</td> --}}
                                <th>{{ $employee->NIN }}</th>
                                {{--                     <th>{{ $employee->RIB }}</th> --}}
                                {{--  <th>{{ $employee->address }}</th> --}}
                                {{--   <th>{{ $employee->ACTIVENIN }}</th> --}}
                                <td>

                                  {{--   <div class="d-flex justify-content-center ml-2 ">

                                        <a type="submit" href="{{ route('director-tresor-edit', $employee->MATRI) }}"
                                            class="btn text-white btn-primary  ml-2">تعديل</a>

                                    </div> --}}
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
