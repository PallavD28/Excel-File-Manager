@extends('layouts.app')

@section('content')
<div class="w-full h-full p-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
    </div>
    
    <!-- File Upload Form -->
    <form id="uploadForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                Upload Excel File (.xlsx, .xls)
            </label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="previewFile(event)">
            @error('file')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Upload File
        </button>
    </form>
    
    <!-- File Preview Table -->
    <div id="filePreview" class="mt-4 overflow-auto">
        <!-- Preview table will be shown here -->
    </div>
</div>

<script>
    function previewFile(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            // Assuming first sheet is used
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];

            // Convert sheet to HTML table
            const htmlTable = XLSX.utils.sheet_to_html(sheet, { id: 'excelTable', editable: false });

            // Display HTML table in preview area
            document.getElementById('filePreview').innerHTML = htmlTable;

            // Add Tailwind CSS classes to the generated table
            styleTable();
        };

        reader.readAsArrayBuffer(file);
    }

    function styleTable() {
        const table = document.getElementById('excelTable');
        table.classList.add('min-w-full', 'bg-white', 'border-collapse');
        
        const headers = table.querySelectorAll('thead th');
        headers.forEach(header => {
            header.classList.add('bg-gray-100', 'text-left', 'px-4', 'py-2', 'border-b', 'font-bold', 'text-sm', 'text-gray-700');
        });
        
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                cell.classList.add('px-4', 'py-2', 'border-b', 'text-sm', 'text-gray-700');
                if (index % 2 === 0) {
                    cell.classList.add('bg-gray-50');
                }
            });
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
@endsection
