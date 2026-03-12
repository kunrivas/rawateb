@extends('layouts.admin')
@section('title')
    حجز المردودية
@endsection
@section('content-title')
    {{--   <h6>حجز المردودية لمؤسسة "{{ $rendement_reservations_statistic->establishment->estab_ar_name }}" </h6> --}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">قائمة الملؤسسات </a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin-rendements') }}">تسير المردودية </a></li>
@endsection

@section('css')
    <style>
        .dropdown-item {
            font-size: 12px
        }

        tr.saved {
            background: #00800030;
        }

        tr.new {
            background: #ff000036;
        }

        tr.saved-0 {
            background: #ffa50040;
        }

        tr.new td,
        tr.saved td {
            background: transparent;
        }
    </style>
@endsection

@section('contents')


<div class="row mb-4" >
         <div class="col">
            <button onclick="exportExcel()" class="btn btn-success">
                Export Excel
            </button>
         </div>
</div>
    <div class="row">
    
        <div class="col">
            
            <table class="table " id="employeesTable" >
                <thead>
                    <tr>
                        <th scope="col">الرقم</th>
                        <th scope="col">الرمز</th>
                        <th scope="col"> اللقب </th>
                        <th scope="col"> الإسم </th>
                        <th scope="col"> الوظيفة </th>
                        <th scope="col"> المأمن </th>
                        <th scope="col">الإدارة </th>
                        {{-- <th scope="col">نقطة المردودية </th> --}}


                    </tr>
                </thead>
                <tbody>

                    @if (!empty($employees) && $employees->count())
                        {{--    @foreach ($employees as $key => $value)
                            <tr
                                @isset($value->point) @if ($value->point == 0) class="saved-0"@else    class="saved" @endif  @else class="new" @endisset>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->MATRI }}</td>
                                <td>{{ $value->employee->NOMA }}</td>
                                <td>{{ $value->employee->PRENOMA }}</td>
                                <td>{{ $value->employee->fonction->LIBTABA ?? '' }}</td>
                                <td>{{ $value->employee->adm->ADM ?? '' }}</td>
                                <td>{{ $value->abs }}
                                </td>
                                <td>{{ $value->point ?? '' }}
                                </td>



                            </tr>
                        @endforeach --}}

                        @foreach ($employees as $adm => $value)
                            {{--        <tr class="table-primary">
                                <th colspan="8">ADM: {{ $adm }}</th>
                            </tr>

                            @foreach ($group as $key => $value)
                                <tr
                                    @isset($value->point)
                @if ($value->point == 0)
                    class="saved-0"
                @else
                    class="saved"
                @endif
            @else
                class="new"
            @endisset> --}}

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->MATRI }}</td>
                            <td>{{ $value->NOMA }}</td>
                            <td>{{ $value->PRENOMA }}</td>
                            <td>{{ $value->fonction ?? '' }}</td>
                            <td>{{ $value->establishment->estab_ar_name ?? '' }}</td>
                            {{--  <td>{{ $employee->NUMSS }}</td> --}}

                            <td>{{ $value->ADM ?? '' }}</td>
                            {{-- <td>{{ $value->abs }}</td>
                                    <td>{{ $value->point ?? '' }}</td> --}}
                            </tr>
                            {{--          @endforeach --}}
                        @endforeach
                    @else
                        <tr>

                            <td colspan="10">There are no data.</td>

                        </tr>
                    @endif
                </tbody>

            </table>
          {{--   {{ $employees->appends(request()->input())->links() }} --}}
        </div>
    </div>
    </form>

@endsection
@section('js')
<script>

function exportExcel() {

    let table = document.getElementById("employeesTable");
    let html = table.outerHTML;

    let file = new Blob([html], {
        type: "application/vnd.ms-excel"
    });

    let url = URL.createObjectURL(file);

    let a = document.createElement("a");
    a.href = url;
    a.download = "employees_not_reserved.xls";

    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
}

</script>

    <script defer></script>
@endsection
