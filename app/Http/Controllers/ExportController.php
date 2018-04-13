<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TestExport;
use Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new TestExport, 'test.xlsx');
    }

    public function viewTable()
    {
        return view('excel.export');
    }
}
