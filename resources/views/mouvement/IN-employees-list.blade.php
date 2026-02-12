@extends('layouts.index')
{{-- linked by yield in parent view --}}
@section('title')
    معالجة الطلبات المرسلة
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">معالجة الطلبات الواردة</a></li>
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

                <table class="table table-striped mt-4" id="emptab">

                    <thead>
                        <tr>
                            <th scope="col">الرمز</th>
                            <th scope="col">الإسم</th>
                            <th scope="col">اللقب</th>
                            <th scope="col">تاريخ الميلاد</th>
                            <th scope="col">رقم الضمان الاجتماعي</th>
                            <th scope="col">المؤسسة الحالية</th>
                            <th scope="col">رمز المؤسسة</th>
                            <th scope="col">الرتبة </th>
                            <th scope="col">إختر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inMouvEmployees as $inMouvEmployee)
                            <tr>
                                <th>{{ $inMouvEmployee->MATRI }}</th>
                                <td>{{ $inMouvEmployee->employee->PRENOMA }}</td>
                                <td>{{ $inMouvEmployee->employee->NOMA }}</td>

                                @if ($inMouvEmployee->employee->DATNAIS)
                                    <td>{{ $inMouvEmployee->employee->DATNAIS ?? '/' }}</td>
                                @else
                                    <td></td>
                                @endif

                                <td>{{ $inMouvEmployee->employee->NUMSS ?? '/' }}</td>
                                <td>{{ $inMouvEmployee->from_establishment->estab_ar_name ?? '/' }}</td>
                                <td>{{ $inMouvEmployee->ESTAB_FROM ?? '/' }}</td>

                                <td>{{ $inMouvEmployee->employee->fonction->LIBTABA ?? '/' }}</td>

                                <td>

                                    <div class="d-flex justify-content-center ml-2 ">
                                        <a href=" {{ route('mouvement-single-cancel', ['id' => $inMouvEmployee->id]) }}"
                                            class="btn text-white btn-primary  ml-2">إلغاء الطلب</a>

                                    </div>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>

                </table>
                {{-- to link table by pagination  --}}

                {{-- {{ $employees->links() }}  --}}
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
