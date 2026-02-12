@extends('layouts.index')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    <h1> إضافة موظف </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">إضافة موظف </a></li>
    <li class="breadcrumb-item"><a href="#">حجز المردودية </a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }
    </style>
@endsection

@section('contents')
    <div class="row">
        <div class="col">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fa fa-exclamation-triangle mx-2"></i>ملاحظة هامة</h5>
                عندما تريد إضافة موظف موجود في مؤسسة اخرى قم بطلبه عن طريق حركة الموظفين وسيتم إضافته بشكل تلقائي لهاته
                القائمة
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col"> </th>

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($employees) && $employees->count())
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->MATRI }}</td>
                                <td>{{ $employee->NOMA }}</td>
                                <td>{{ $employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA?? ""}}</td>
                                </td>

                                <td>
                                    <form method="post" action="{{ route('rendements-reservation-employee-add') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm ">إضافة</button>
                                        <input type="hidden" name="MATRI" value="{{ $employee->MATRI }}">
                                        <input type="hidden" name="rendement_reservations_id"
                                            value="{{ $rendementReservation->id }}">
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td colspan="10">لا يوجد هنالك موظفين</td>

                        </tr>
                    @endif
                </tbody>

            </table>

        </div>
    </div>
    </form>

@endsection
@section('js')
    <script defer>
        $(".run").click(function(evt) {
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
            $(this).attr('disabled', 'disabled');
            setTimeout(() => {
                location.reload();
            }, 5000);

        });
    </script>
@endsection
