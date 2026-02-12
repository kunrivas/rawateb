<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: aegyptus;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        /* header table */
        .no-border td {
            border: none;
        }
        .aligncenter {
            text-align: center;
        }
        .font16 {
            font-size: 16px;
        }
        .font24 {
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>
<body>

{{-- ======= HEADER ======= --}}
<table class="no-border font16" style="width:100%; margin-bottom:20px;">
    <tr>
        <td colspan="12" class="aligncenter font24">
            الجمهورية الجزائرية الديمقراطية الشعبية
        </td>
    </tr>
    <tr>
        <td colspan="12" class="aligncenter font24">
            وزارة التربية الوطنية
        </td>
    </tr>
    <tr>
        <td colspan="12" class="aligncenter font24">
            مديرية التربية لولاية الوادي
        </td>
    </tr>
    <tr>
        <td colspan="12">
            <strong>المؤسسة:</strong>
            @if (is_null(session()->get("establishment")))
                /
            @else
                {{ session()->get("establishment")->estab_ar_name }}
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="12">
            <strong>رمز المؤسسة:</strong>
            @if (is_null(session()->get("establishment")))
                /
            @else
                {{ session()->get("establishment")->estab_rawateb_user }}
            @endif
        </td>
    </tr>
</table>

{{-- ======= TITLE ======= --}}
<h3 align="center">
كشف اقتطاعات الخدمات الفردي الموظف "{{ $employee->NOMA }} {{ $employee->PRENOMA }}" للسنة {{ $year }}                                                                   
</h3>

{{-- <p>
    الموظف: {{ $employee->NOMA }} {{ $employee->PRENOMA }} <br>
    السنة: {{ $year }}
</p> --}}

{{-- ======= DATA TABLE ======= --}}
<table>
    <thead>
        <tr>
            <th>الشهر</th>
            <th>المبلغ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
            <tr>
                <td>{{ Mlibrary::getArabicMonth($row['month']) }}</td>
                <td>{{ number_format($row['amount'], 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <th>المجموع</th>
            <th>{{ number_format($total, 2) }}</th>
        </tr>
    </tbody>
</table>

</body>
</html>
