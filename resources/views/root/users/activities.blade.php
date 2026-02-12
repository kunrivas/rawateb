@extends('layouts.admin')
{{-- linked by yield in parent view --}}
@section('title')
    سجل نشاط مستخدم
@endsection
{{-- linked by yield in parent view --}}
@section('content-title')
    <h1> سجل نشاط مستخدم </h1>
@endsection
{{-- linked by yield in parent view --}}
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#"> سجل نشاط مستخدم </a></li>
    <li class="breadcrumb-item"><a href="#"> حسابات المستخدمين </a></li>
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


            <div class="mt-4">

                <form method="post" action="{{ route('root-user-list') }}">
                    @csrf
                    <div class="col-6 input-group mb-3 row">
                        <div class="col-2  text-center">إبحث عن</div>
                        <div class="col-8" style="position: relative">
                            <input type="text" class="form-control" id="search" name="search" placeholder="العملية"
                                value="{{ $search }}">
                        </div>

                        <button class="btn btn-info col-2" type="submit" id="button">إبحث</button>
                    </div>
                </form>

                <table class="table table-striped mt-4" id="emptab">

                    <thead>
                        <tr>
                            <th scope="col">الرقم</th>
                            <th scope="col">العملية</th>
                            <th scope="col">تاريخ</th>
                            <th scope="col">رقم IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activitie)
                            <tr>
                                <th></th>


                            </tr>
                        @endforeach


                    </tbody>

                </table>
                {{-- to link table by pagination  --}}
                {{--  {{ $users->links() }} --}}
                {{-- to link table by pagination with selected values like select adms select status  --}}
                {{--  --}}

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
