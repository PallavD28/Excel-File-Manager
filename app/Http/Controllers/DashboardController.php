<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Database\Schema\Blueprint;
use App\Models\FileUpload;
use Log;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function manageAccount()
    {
        return view('dashboard.account');
    }

    public function showFileUploadForm()
    {
        return view('dashboard.upload-file');
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $fileName = time() . '_' . $originalFileName;
        $filePath = $file->storeAs('uploads', $fileName);

        // Parse Excel file to get column headers and data
        $columns = $this->parseExcelColumns($filePath);
        $data = $this->parseExcelData($filePath, $columns);

        Log::info('Parsed columns: ' . json_encode($columns));
        Log::info('Parsed data: ' . json_encode($data));

        // Generate table name including file name
        $tableName = 'user_' . Auth::id() . '_' . time() . '_' . pathinfo($originalFileName, PATHINFO_FILENAME);

        // Create database table
        $this->createDatabaseTable($tableName, $columns);

        // Insert data into the table
        $this->insertDataIntoTable($tableName, $data);

        $fileUpload = new FileUpload();
        $fileUpload->user_id = Auth::id();
        $fileUpload->file_name = $fileName;
        $fileUpload->table_name = $tableName;
        $fileUpload->save();

        return redirect()->route('dashboard')->with('success', 'File uploaded successfully.');
    }

    private function parseExcelColumns($filePath)
    {
        try {
            $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
            $sheet = $spreadsheet->getActiveSheet();
            $columnCount = $sheet->getHighestColumn();
            $columns = [];

            for ($col = 'A'; $col <= $columnCount; $col++) {
                $cellValue = $sheet->getCell($col . '1')->getValue();
                $columns[] = $cellValue;
            }

            return $columns;
        } catch (\Exception $e) {
            Log::error('Error parsing Excel file: ' . $e->getMessage());
            return [];
        }
    }

    private function parseExcelData($filePath, $columns)
    {
        try {
            $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
            $sheet = $spreadsheet->getActiveSheet();
            $rowCount = $sheet->getHighestRow();
            $data = [];

            for ($row = 2; $row <= $rowCount; $row++) {
                $rowData = [];
                $colIndex = 0;
                foreach ($columns as $colName) {
                    $colLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                    $cellValue = $sheet->getCell($colLetter . $row)->getValue();
                    $rowData[$colName] = $cellValue;
                    $colIndex++;
                }
                $data[] = $rowData;
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('Error parsing Excel data: ' . $e->getMessage());
            return [];
        }
    }

    private function createDatabaseTable($tableName, $columns)
    {
        try {
            Schema::create($tableName, function (Blueprint $table) use ($columns) {
                $table->bigIncrements('id');
                foreach ($columns as $column) {
                    if ($column !== 'id' && $column !== 'created_at' && $column !== 'updated_at') {
                        $table->string($column)->nullable();
                    }
                }
            });
            Log::info('Table created: ' . $tableName);
        } catch (\Exception $e) {
            Log::error('Error creating database table: ' . $e->getMessage());
        }
    }

    private function insertDataIntoTable($tableName, $data)
    {
        try {
            DB::table($tableName)->insert($data);
            Log::info('Data inserted into table: ' . $tableName);
        } catch (\Exception $e) {
            Log::error('Error inserting data into table: ' . $e->getMessage());
        }
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function viewTables()
    {
        $tables = FileUpload::where('user_id', Auth::id())->get();

        return view('dashboard.view-tables', compact('tables'));
    }

    public function viewTableData($tableName)
    {
        try {
            if (!Schema::hasTable($tableName)) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
            }
        
            $tableData = DB::table($tableName)->get();
            $columns = Schema::getColumnListing($tableName);
        
            return view('dashboard.view-table', compact('tableData', 'columns', 'tableName'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
}