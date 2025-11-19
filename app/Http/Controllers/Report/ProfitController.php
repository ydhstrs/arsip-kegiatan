<?php

namespace App\Http\Controllers\Report;

use App\Exports\ExpenseExport;
use App\Models\RoomMove;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Room;
use App\Models\Log;
use App\Models\Bill;
use App\Exports\IncomeExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        $idUser = Auth::id();
        if ($request->from == null && $request->to == null) {
            $from = Carbon::now()->startOfMonth()->toDateString(); // Tanggal 1 bulan ini
            $to = Carbon::now()->endOfMonth()->toDateString(); // Tanggal akhir bulan ini
        } else {
            $from = $request->from;
            $to = $request->to;
        }
        $filter = Transaction::whereBetween('date', [$from, $to])
            ->latest()
            ->paginate(200);

        // $totalUangMasuk = Transaction::whereBetween('date', [$from, $to])
        //     ->sum('total_amount');

        $uangKeluar = Transaction::whereBetween('date', [$from, $to])
            ->where('transaction_type', 'Buying')
            ->orwhere('transaction_type', 'Paying')
            ->sum('amount');
        $uangMasuk = Transaction::whereBetween('date', [$from, $to])
            ->where('transaction_type', 'Checkin')
            ->orwhere('transaction_type', 'Bill')
            ->sum('amount');

        $total = $uangMasuk - $uangKeluar;

        // ddd($filter);

        session()->flashInput($request->input());

        // ddd($filter);

        return view('backend.report.profit.index', [
            'items' => $filter,
            'title' => 'Laporan Laba',
            'total' => $total,
        ]);
    }
}
