<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Paying;
use Illuminate\Support\Facades\Auth;

class PayingController extends Controller
{
    public function getData(Request $request)
    {
        $items = Paying::select(['id', 'transaction_no', 'name', 'amount', 'transaction_date', 'created_at'])->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '
                    <a href="' .
                    route('paying.show', $item->id) .
                    '" class="btn btn-sm btn-info">View</a>
                    <a href="' .
                    route('paying.edit', $item->id) .
                    '" class="btn btn-sm btn-primary">Edit</a>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.transaction.paying.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Pembayaran',
        ]);
    }

    public function create(): View
    {
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        $month_files = Transaction::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();

        $counter = $month_files;

        if ($month_files != 0) {
            ++$counter;
        } else {
            $counter = 1;
        }
        return view('backend.transaction.paying.create', [
            'counter' => $counter,
            'title' => 'Tambah Pembayaran',
        ]);
    }
    public function store(Request $request)
    {
        // START COUNTER TRANSAKSI
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        $month_files = Transaction::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();

        $counter = $month_files;

        if ($month_files != 0) {
            ++$counter;
        } else {
            $counter = 1;
        }
        // END COUNTER TRANSAKSI
        // @ddd($request);
        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        $validatedData = $request->validate([
            'transaction_no' => 'required',
            'name' => 'required|max:255',
            'transaction_date' => 'required|date',
            'amount' => 'required|max:255',
            'image' => 'required',
            'remark' => '',
            'created_by' => '',
        ]);
        $transNo = 'PAY/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT);
        $validatedData['transaction_no'] = $transNo;
        $validatedData['created_by'] = $idUser;
        $validatedData['amount'] = (int) str_replace('.', '', $request->amount);
        // dd($validatedData   );

        Paying::create($validatedData);
        Log::create([
            'activity' => "$nameUser Membuat Pembayaran $request->name Dengan Nomor $transNo ",
            'created_by' => $idUser,
        ]);
        if ($request->room_id == null) {
            $roomId = 0;
        } else {
            $roomId = $request->room_id;
        }
        Transaction::create([
            'transaction_type' => 'Paying',
            'transaction_no' => $transNo,
            'date' => $request->transaction_date,
            'room_id' => $roomId,
            'amount' => $validatedData['amount'],
            'created_by' => $idUser,
        ]);

        return redirect('/dashboard/paying')->with('success', 'Transaksi Baru Telah Ditambahkan');
    }

    public function edit(Paying $paying)
    {

        return view('backend.transaction.paying.edit', [
            'title' => 'Edit Pembayaran',
            'item' => $paying,
        ]);
    }

    public function update(Request $request, Paying $paying)
    {

        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        // Validasi data input
        $validatedData = $request->validate([
            'transaction_no' => '',
            'name' => 'required|max:255',
            'transaction_date' => 'required|date',
            'amount' => 'required|max:255',
            'image' => 'nullable',
            'remark' => 'nullable',
        ]);

        // Update data pembayaran
        $validatedData['amount'] = (int) str_replace('.', '', $request->amount);

        $paying->update($validatedData);

        Log::create([
            'activity' => "$nameUser Memperbarui Pembayaran $request->name Dengan Nomor $paying->transaction_no",
            'created_by' => $idUser,
        ]);

        // Update data transaksi
        $roomId = $request->room_id ?? 0;

        Transaction::where('transaction_no', $paying->transaction_no)->update([
            'transaction_type' => 'Paying',
            'date' => $request->transaction_date,
            'room_id' => $roomId,
            'amount' => $validatedData['amount'],
            'created_by' => $idUser,
        ]);

        return redirect('/dashboard/paying')->with('success', 'Transaksi Telah Diperbarui');
    }

    public function show(Paying $paying)
    {
        return view('backend.transaction.paying.detail', [
            'item' => $paying,
            'title' => 'Detail Check In',
        ]);
    }
    public function destroy(Paying $paying)
    {
        $paying = Paying::findOrFail($paying->id);
        $paying->delete();

        return redirect('/dashboard/paying')->with('success', 'Transaksi Telah Dihapus');
    }
}
