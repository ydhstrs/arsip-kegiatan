<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\App; // Untuk menggunakan facade App
use Illuminate\Support\Facades\Auth;
use PDF;
class BillController extends Controller
{
    public function getData(Request $request)
    {
        $items = Bill::select(['bills.id', 'bills.transaction_no', 'bills.guest_name', 'bills.payment_date', 'bills.bill_date', 'bills.amount', 'rooms.name as room_name', 'bills.created_at'])
            ->join('rooms', 'bills.room_id', '=', 'rooms.id')
            ->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                // Check if payment_date is not null and add the Print button
                if ($item->payment_date) {
                    $actionButtons = ' <a href="' . route('bill.print', $item->id) . '" class="btn btn-sm btn-primary">Print</a>
                    <form action="'.route('bill.destroy', $item->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Checkout</button>
                        </form>';
                } else {
                    $actionButtons = '<a href="' . route('bill.edit', $item->id) . '" class="btn btn-sm btn-info">Bayar</a>
                    <form action="'.route('bill.destroy', $item->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Checkout</button>
                        </form>';
                }
                

                return $actionButtons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.transaction.bill.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Bill',
        ]);
    }

    public function update(Request $request, Bill $bill)
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
        $amount = str_replace('.', '', $request->amount);
        $validatedData = $request->validate([
            'payment_date' => 'required|date',
            'duration' => 'required|max:11',
            'image' => '',
            'amount' => '',
        ]);
        $validatedData['amount'] = $amount ;
        // $validatedData['amount'] = (int) str_replace('Rp', '', $validatedData['a\mount']);
        // $validatedData['amount'] = $validatedData['amount'] * $validatedData['duration'] ;

        Bill::where('id', $bill->id)->update($validatedData);
        $room = Room::find($bill->room_id);

        Log::create([
            'activity' => "$nameUser Membuat Payment Bill Atas Nama $bill->guest_name Dengan Nomor $bill->transaction_no",
            'created_by' => $idUser,
        ]);

        // Use the checkin_date from the request to calculate the bill date
        $paymentDate = Carbon::parse($request->bill_date);
        $billDate = $paymentDate->addMonths($request->duration); // Calculate the bill date based on checkin_date
        // dd($request);
        Transaction::create([
            'transaction_type' => 'Bill',
            'transaction_no' => $bill->transaction_no,
            'date' => $request->payment_date,
            'guest_name' => $bill->guest_name,
            'room_id' => $bill->room_id,
            'amount' => $validatedData['amount'],
            'created_by' => $idUser,
        ]);

        Bill::create([
            'transaction_no' => 'B/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT)+1,
            'bill_date' => $billDate, // Use the calculated bill date
            'guest_name' => $request->guest_name, // Use the calculated bill date
            'room_id' => $bill->room_id, // Use the calculated bill date
            'amount' => $room->price, // Adjust this according to your billing logic
            'created_by' => $idUser,
        ]);

        return redirect('/dashboard/bill')->with('success', 'Bill Telah Dibayar');
    }
    public function print($id)
    {
        $bill = Bill::with('room')->findOrFail($id); // Ambil data checkin dengan relasi room
        $pdf = App::make('dompdf.wrapper'); // Instansiasi DomPDF

        // Load view untuk PDF
        $pdf->loadView('backend.transaction.bill.print', [
            'bill' => $bill,
            'title' => 'Kwitansi Pembayaran',
        ])->setPaper('a5', 'portrait');

        // Stream PDF ke browser
        // return $pdf->stream('checkin-' . $checkin->id . '.pdf');
        return response($pdf->stream('bill-' . $bill->id . '.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="checkin-' . $bill->id . '.pdf"');
    }

    public function create()
    {
    }

    public function edit(Bill $bill)
    {
        
        return view('backend.transaction.bill.edit', [
            'item' => $bill,
            'title' => 'Bayar Bill',
            'users' => User::all(),

        ]);
    }
    public function store(Request $request)
    {
    }

    public function show(Bill $bill)
    {
        return view('backend.transaction.bill.detail', [
            'item' => $bill,
            'title' => 'Detail Bill',
        ]);
    }
    public function destroy(Bill $bill)
    {
        $today = Carbon::today();

        $idUser = Auth::id();
        $nameUser = Auth::user()->name;
        $bill = Bill::findOrFail($bill->id);
        $bill->delete();
        Room::where('id', $bill->room_id)->update(['is_available' => 1]);
        Log::create([
            'activity' => "$nameUser Melakykan Checkout $bill->guest_name Dengan Nomor $bill->transaction_no pada  $today",
            'created_by' => $idUser,
        ]);
        return redirect('/dashboard/bill')->with('success', 'Bill Berhasil Checkout');
    }
}
