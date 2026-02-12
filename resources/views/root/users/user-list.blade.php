@extends('layouts.admin')
{{-- linked by yield in parent view --}}
@section('title')
    قائمة حسابات المستخدمين
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> قائمة حسابات المستخدمين </h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#"> قائمة حسابات المستخدمين </a></li>
    <li class="breadcrumb-item"><a href="#">تسير حسابات المستخدمين</a></li>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    هنالك خطأ في حجز المعلومات
                </div>
            @endif

            <div class="mt-4">

                <form method="post" action="{{ route('root-user-list') }}">
                    @csrf
                    <div class="col-6 input-group mb-3 row">
                        <div class="col-2  text-center">إبحث عن</div>
                        <div class="col-8" style="position: relative">
                            <input type="text" class="form-control" id="search" name="search" placeholder="موظف"
                                value="{{ $search }}">
                        </div>

                        <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
                    </div>
                </form>

                <table class="table table-striped mt-4" id="emptab">

                    <thead>
                        <tr>
                            <th scope="col">الرقم التعريفي</th>
                            <th scope="col">إسم المستخدم</th>
                            <th scope="col">الاسم واللقب</th>
                            <th scope="col">الوظيفة</th>
                            <th scope="col">رقم الهاتف</th>
                            <th scope="col">البريد الإكتروني</th>
                            <th scope="col">الحالة</th>
                            <th scope="col"> العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ '03900000' . $user->id }}</th>
                                <td>{{ $user->user_username }}</td>
                                <td>{{ $user->user_fullname }}</td>
                                <td>{{ $user->user_profession }}</td>
                                <td>{{ $user->user_mobile }}</td>
                                <td>{{ $user->user_email }}</td>
                                @if ($user->user_status)
                                    <td class="badge badge-success">مفعل</td>
                                @else
                                    <td class="badge badge-danger">غير مفعل</td>
                                @endif

                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-success btn-sm">العمليات</button>
                                        <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only"> </span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item " href="{{ route('root-user-edit', $user->id) }}">تعديل
                                                المعلومات</a>
                                            <a class="dropdown-item " href="{{ route('root-user-activities', $user->id) }}">سجل
                                                النشاط </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>

                </table>
                {{-- to link table by pagination  --}}
                {{--  {{ $users->links() }} --}}
                {{-- to link table by pagination with selected values like select adms select status  --}}
                {{ $users->appends(request()->input())->links() }}

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
