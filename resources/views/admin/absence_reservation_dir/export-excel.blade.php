<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export to Excel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>

<body>
    <table id="myTable" border="1">
        <thead>
            <tr>
                <th>رقم الموضف</th>
                <th>الاسم</th>
                <th>اللقب</th>
                <th>تاريخ البداية</th>
                <th>تاريخ النهاية</th>
                <th>عدد الايام</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absence_reservation_employeess as $absence_reservation_employees)
                <tr>
                    <td>{{ '@' . $absence_reservation_employees["MATRI"] ??"/"}}</td>
                    <td>{{ $absence_reservation_employees["PRENOMA"] }}</td>
                    <td>{{ $absence_reservation_employees["NOMA"]}}</td>
                    <td>{{ $absence_reservation_employees["DAY_FROM"]}}</td>
                    <td>{{ $absence_reservation_employees["DAY_TO"]}}</td>
                    <td>{{ $absence_reservation_employees["NBR_DAYS"] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            exportToExcel();
            closeWindow();
        };

        function exportToExcel() {
            // Get the table element
            const table = document.getElementById('myTable');

            // Convert the table to a worksheet
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: 'Sheet1'
            });

            // Access the worksheet
            const worksheet = workbook.Sheets['Sheet1'];

            Object.keys(worksheet).forEach(cell => {
                if (cell[0] === "A" && cell !== "A1") { // Only process column A, excluding header
                    let cellValue = worksheet[cell].v; // Get the current cell value
                    if (typeof cellValue === "string" && cellValue.startsWith("@")) {
                        worksheet[cell].v = cellValue.slice(1); // Remove the '@' character
                    }
                    worksheet[cell].t = "s"; // Ensure the cell is treated as text
                }
            });
            // Export the workbook to an Excel file
            XLSX.writeFile(workbook, '{{ $YEAR }}-{{ $MONTH }}-ADM-{{ $ADM }}.xlsx');
        }

        function closeWindow() {
            // Close the window after export
               window.close();
        }
    </script>
</body>

</html>
