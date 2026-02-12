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
                <th>MATRI</th>
                <th>NOMA</th>
                <th>PRENOMA</th>
                <th>ADM</th>
                <th>AFFECT</th>
                <th>NIN</th>
                <th>DATNAIS</th>
              {{--   <th>RIB</th> --}}
              {{--   <th>address</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($tresor_employeess as $tresor_employees)
                <tr>
                    <td>{{ '@' . ($tresor_employees->MATRI ?? '/') }}</td>
                    {{--    <td>{{ $tresor_employees->MATRI }}</td> --}}
                    <td>{{ $tresor_employees->NOMA }}</td>
                    <td>{{ $tresor_employees->PRENOMA }}</td>
                    <td>{{ $tresor_employees->ADM }}</td>
                    <td>{{ $tresor_employees->AFFECT }}</td>
                   <td>{{ "'" . ($tresor_employees->NIN ?? '/') }}</td>
                    <td>{{ $tresor_employees->DATNAIS }}</td>
              {{--       <td>{{ $tresor_employees->RIB }}</td> --}}
                 {{--    <td>{{ $tresor_employees->address }}</td> --}}
                 
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
    const workbook = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });

    // Access the worksheet
    const worksheet = workbook.Sheets['Sheet1'];

    // Force column A (MATRI) and F (NIN) to be text
    Object.keys(worksheet).forEach(cell => {
        if (cell[0] === "A" && cell !== "A1") { // Column MATRI
            let cellValue = worksheet[cell].v;
            if (typeof cellValue === "string" && cellValue.startsWith("@")) {
                worksheet[cell].v = cellValue.slice(1);
            }
            worksheet[cell].t = "s"; // Text
        }

        if (cell[0] === "F" && cell !== "F1") { // Column NIN
             let cellValue = worksheet[cell].v;
        if (typeof cellValue === "string" && cellValue.startsWith("'")) {
            worksheet[cell].v = cellValue.slice(1); // remove leading '
        }

            worksheet[cell].t = "s"; // Force as text
        }
    });

    // Export the workbook to an Excel file
    XLSX.writeFile(workbook, 'tresor.xlsx');
}

        function closeWindow() {
            // Close the window after export
               window.close();
        }
    </script>
</body>

</html>
