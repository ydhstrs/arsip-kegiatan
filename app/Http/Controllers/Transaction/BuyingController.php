<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Buying;
use Illuminate\Support\Facades\Auth;

class BuyingController extends Controller
{
    public function getData(Request $request)
    {
        $items = Buying::select(['id', 'transaction_no', 'name', 'price', 'buying_date', 'created_at'])->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a href="' .
                    route('buying.show', $item->id) .
                    '" class="btn btn-sm btn-info">View</a>
                    <a href="' .
                    route('buying.edit', $item->id) .
                    '" class="btn btn-sm btn-primary">Edit</a>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.transaction.buying.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Pembelian',
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
        return view('backend.transaction.buying.create', [
            'counter' => $counter,
            'title' => 'Tambah Pembelian',
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
            'name' => 'required|max:255',
            'buying_date' => 'required|date',
            'price' => 'required',
            'image' => '',
            'remark' => '',
            'created_by' => '',
        ]);
        $transNo = 'BUY/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT);
        $validatedData['transaction_no'] = $transNo;
        $validatedData['created_by'] = $idUser;
        $validatedData['price'] = (int) str_replace('.', '', $request->price);

        // dd($validatedData   );

        $buying = Buying::create($validatedData);
        Log::create([
            'activity' => "$nameUser Membeli $request->name Dengan Nomor $transNo ",
            'created_by' => $idUser,
        ]);
        Transaction::create([
            'transaction_type' => 'Buying',
            'transaction_no' => $transNo,
            'date' => $request->buying_date,
            'amount' => $validatedData['price'],
            'created_by' => $idUser,
        ]);

        Asset::create([
            'name' => $request->name,
            'buying_id' => $buying->id,
            'buying_date' => $request->buying_date,
            'buying_price' => $validatedData['price'],
            'remark' => $request->remark,
        ]);

        return redirect('/dashboard/buying')->with('success', 'Transaksi Baru Telah Ditambahkan');
    }
    public function edit(Buying $buying)
    {
        return view('backend.transaction.buying.edit', [
            'title' => 'Edit Pembelian',
            'item' => $buying,
        ]);
    }

    public function update(Request $request, Buying $buying)
    {
        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        // Validasi data input
        $validatedData = $request->validate([
            'transaction_no' => '',
            'name' => 'required|max:255',
            'buying_date' => 'required|date',
            'price' => 'required',
            'image' => '',
            'remark' => '',
        ]);
        // Update data pembayaran
        $validatedData['price'] = (int) str_replace('.', '', $request->price);
        $buying->update($validatedData);

        Log::create([
            'activity' => "$nameUser Memperbarui Pembelian $request->name Dengan Nomor $buying->transaction_no",
            'created_by' => $idUser,
        ]);

        Transaction::where('transaction_no', $buying->transaction_no)->update([
            'transaction_type' => 'Buying',
            'date' => $request->buying_date,
            'amount' => $validatedData['price'],
            'created_by' => $idUser,
        ]);

        Asset::updateOrCreate(
            ['buying_id' => $request->id], // Criteria to find existing record
            [
                'name' => $request->name,
                'buying_date' => $request->buying_date,
                'buying_price' => $validatedData['price'],
                'remark' => $request->remark,
            ],
        );

        return redirect('/dashboard/buying')->with('success', 'Transaksi Telah Diperbarui');
    }
    public function show(Buying $buying)
    {
        return view('backend.transaction.buying.detail', [
            'item' => $buying,
            'title' => 'Detail Pembelian',
        ]);
    }
    public function destroy(Buying $buying)
    {
        $buying = Buying::findOrFail($buying->id);
        $buying->delete();

        return redirect('/dashboard/buying')->with('success', 'Aset Telah Dihapus');
    }
}
