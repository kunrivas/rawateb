@extends('layouts.admin')
@section('title')
    كشف اقتطاعات الخدمات الفردي
@endsection
@section('content-title')
    <h1> كشف اقتطاعات الخدمات الفردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }} "</h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف اقتطاعات الخدمات </a></li>
    <li class="breadcrumb-item"><a href="#">فردي</a></li>
@endsection


@section('contents')
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">السنة</th>
                        {{--         <th scope="col">الثلاثي</th> --}}
                        <th scope="col">إختر</th>
                        {{--    <th scope="col">العمليات</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach (range(2026, 2020) as $year)
                        <tr>
                            <td>{{ $year }}</td>
                            <td>
                                <form action="{{ route('admin-deduction-single-year-print') }}" method="post"
                                    target="_blank">
                                    @csrf
                                    <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                    <input type="hidden" name="YEAR" value="{{ $year }}">

                                    <button class="btn btn-primary btn-sm">
                                        عرض الإقتطاعات
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            {{--    {{ $tamadres_singles->links() }}  --}}
        </div>
    </div>
@endsection
