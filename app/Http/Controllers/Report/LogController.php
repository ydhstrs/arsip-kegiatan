<?php

namespace App\Http\Controllers\Report;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Log;

class LogController extends Controller
{

     public function getData(Request $request)
    {
        $items = Log::select(['id', 'activity','created_at'])->get();
        return DataTables::of($items)
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.report.log.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Log Aktivitas',
        ]);
    }
}
