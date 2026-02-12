@extends('layouts.admin')
{{-- linked by yield in parent view --}}
@section('title')
    معالجة الطلبات الواردة
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة الموظفين</h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">معالجة الطلبات المرسلة</a></li>
    <li class="breadcrumb-item"><a href="#">قائمة الموظفين</a></li>
@endsection

{{-- chang content linked by yield in parent view --}}
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
                            <th scope="col">المؤسسة الطالبة</th>
                            <th scope="col">رمز م الطالبة</th>
                            <th scope="col">المؤسسة الأصلية</th>
                            <th scope="col">رمز م الأصلية</th>

                            <th scope="col">الرتبة </th>

                            <th scope="col">إختر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outMouvEmployees as $outMouvEmployee)
                            <tr>
                                <th>{{ $outMouvEmployee->MATRI }}</th>
                                <td>{{ $outMouvEmployee->employee->PRENOMA }}</td>
                                <td>{{ $outMouvEmployee->employee->NOMA }}</td>

                                @if ($outMouvEmployee->employee->DATNAIS)
                                    <td>{{ $outMouvEmployee->employee->DATNAIS ?? '/' }}</td>
                                @else
                                    <td></td>
                                @endif

                                <td>{{ $outMouvEmployee->employee->NUMSS ?? '/' }}</td>
                                <td>{{ $outMouvEmployee->to_establishment->estab_ar_name ?? '/' }}</td>
                                <td>{{ $outMouvEmployee->ESTAB_TO ?? '/' }}</td>

                                <td>{{ $outMouvEmployee->from_establishment->estab_ar_name ?? '/' }}</td>
                                <td>{{ $outMouvEmployee->ESTAB_FROM ?? '/' }}</td>


                                <td>{{ $outMouvEmployee->employee->fonction->LIBTABA ?? '/' }}</td>

                                <td>

                                    <div class="d-flex justify-content-center ml-2 ">
                                        <a href=" {{ route('admin-mouvement-single-in-validate', ['id' => $outMouvEmployee->id]) }}"
                                            class="btn text-white btn-success  ml-2">موافقة</a>

                                        <a href=" {{ route('admin-mouvement-single-cancel', ['id' => $outMouvEmployee->id]) }}"
                                            class="btn text-white btn-danger  ml-2">رفض</a>

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
