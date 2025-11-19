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

class ExpenseController extends Controller
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
            ->where('transaction_type', 'Buying')
            ->orwhere('transaction_type', 'Paying')
            ->latest()
            ->paginate(200);

        // $totalUangMasuk = Transaction::whereBetween('date', [$from, $to])
        //     ->sum('total_amount');

        $uangKeluar = Transaction::whereBetween('date', [$from, $to])->where('transaction_type', 'Buying')
            ->orwhere('transaction_type', 'Paying')->sum('amount');

        // ddd($filter);

        session()->flashInput($request->input());

        // ddd($filter);

        return view('backend.report.expense.index', [
            'items' => $filter,
            'title' => 'Laporan Uang Keluar',
            'grandUangKeluar' => $uangKeluar,
        ]);
    }

    public function export(Request $request)
    {
        $myId = Auth::user()->id_hotel;


        if ($request->from != null) {
            $dateFrom = Carbon::parse($request->from);
            $formattedDate1 = $dateFrom->format('d M Y');
        } else {
            $formattedDate1 = '';
        }
        if ($request->to != null) {
            $dateTo = Carbon::parse($request->to);
            $formattedDate2 = $dateTo->format('d M Y');
        } else {
            $formattedDate2 = '';
        }


        return Excel::download(new ExpenseExport($request->from, $request->to), $formattedDate1.' - '.$formattedDate2.'.xlsx');
    }
}
