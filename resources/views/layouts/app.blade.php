<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css','resources/js/app.js']);
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        <div class="lg:grid grid-cols-11">
            <!-- Sidebar -->
            <div class="col-span-2">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content -->
            <main class="col-span-9">
                {{ $slot }}
            </main>
        </div>
    </div>

   <!-- jQuery and DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables Core Script -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>

<!-- JSZip for Excel Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- PDFMake for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- DataTables Buttons for Export Options -->
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.print.min.js"></script>

<!-- DataTables Column Visibility Button -->
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DataTables Initialization Script -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip', // This specifies the position of the buttons
                lengthMenu: [10, 25, 50, 75, 100], // Options for the number of rows per page
                buttons: [
                    'copy',        // Copy to clipboard
                    'excel',       // Excel export
                    'csv',         // CSV export
                    'pdf',         // PDF export
                    'print',       // Print button
                    {
                        extend: 'colvis', // Column visibility button
                        text: 'Column Visibility' // Custom button text
                    }
                ]
            });
        });
    </script>
</body>
</html>