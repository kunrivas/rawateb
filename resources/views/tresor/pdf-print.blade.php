<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة بيانات الموظوفين</title>
    <style>
body {
    font-family: "dejavusans"; /* خط يدعم العربية */
    direction: rtl;
    font-size: 10pt;
    margin: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 5px;
}

table, th, td {
    border: 1px solid #000;
}

th, td {
    text-align: center;
    padding: 3px;
}

thead td {
    font-weight: bold;
    background-color: #EEE; /* استخدم Hex بدل الأسماء */
}

.font14 { font-size: 14pt; font-weight: bold; }
.font16 { font-size: 16pt; font-weight: bold; }
.font18 { font-size: 18pt; font-weight: bold; }
.font24 { font-size: 24pt; font-weight: bold; }
.font30 { font-size: 30pt; font-weight: bold; }

.aligncenter { text-align: center; }
.rigth { text-align: right; }
.left { text-align: left; }

/* جدول الموظفين */
.case td {
    height: 25px; /* يمكن تغييره إذا تسبب بمشاكل */
    font-size: 14pt;
}

.barcode {
    font-family: "dejavusans";
    font-size: 16pt;
}
</style>

</head>
<body>
@php
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 300);
@endphp

@if(count($employees) > 0)

    @foreach ($employees as $adm => $data)

        <!-- ترويسة المؤسسة -->
        <table>
            <tr>
                <td colspan="6" class="aligncenter font24">الجمهورية الجزائرية الديمقراطية الشعبية</td>
            </tr>
            <tr>
                <td colspan="6" class="aligncenter font24">وزارة التربية الوطنية</td>
            </tr>
            <tr>
                <td colspan="3" class="font16">مديرية التربية لولاية الوادي</td>
                <td colspan="3" class="font16">إلى السيد: مدير التربية</td>
            </tr>
            <tr>
                <td colspan="3">المؤسسة: {{ $establishment->estab_ar_name ?? '' }}</td>
                <td colspan="3" class="font16">مصلحة تسيير نفقات المستخدمين</td>
            </tr>
            <tr>
                <td>رمز المؤسسة: {{ $establishment->estab_rawateb_user ?? '' }}</td>
                <td colspan="5">الإدارة: {{ $adm ?? '' }}</td>
            </tr>
        </table>

        <!-- جدول الموظفين -->
        <table>
            <thead>
                <tr>
                    <td>الرقم</td>
                    <td>الرمز</td>
                    <td>الاسم واللقب</td>
                    <td>رقم الضمان الاجتماعي</td>
                    <td>تاريخ الميلاد</td>
                    <td>رقم التعريف الوطني (NIN)</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $value->MATRI ?? '' }}</td>
                        <td>{{ $value->NOMA ?? '' }} {{ $value->PRENOMA ?? '' }}</td>
                        <td>{{ $value->NUMSS ?? '' }}</td>
                        <td>{{ $value->DATNAIS ?? '' }}</td>
                        <td>{{ $value->NIN ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- توقيع -->
        <table>
            <tr>
                <td>الوادي في: {{ date('Y/m/d') }}</td>
            </tr>
            <tr>
                <td>المسير المالي .................................... المدير ....................................</td>
            </tr>
        </table>

        @if(!$loop->last)
            <pagebreak />
        @endif

    @endforeach

@else
    <table>
        <tr>
            <td>لا يوجد بيانات</td>
        </tr>
    </table>
@endif

</body>
</html>
