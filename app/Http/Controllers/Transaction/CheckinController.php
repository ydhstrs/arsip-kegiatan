<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App; // Untuk menggunakan facade App
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Checkin;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;

class CheckinController extends Controller
{
    public function getData(Request $request)
    {
        $items = Checkin::select(['checkins.id', 'checkins.guest_name', 'checkins.transaction_date', 'checkins.checkin_date', 'checkins.guest_job', 'checkins.amount', 'rooms.name as room_name', 'checkins.created_at'])
            ->join('rooms', 'checkins.room_id', '=', 'rooms.id')
            ->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a href="' .
                    route('checkin.edit', $item->id) .
                    '" class="btn btn-sm btn-primary">Edit</a>
                    <a href="' .
                    route('checkin.show', $item->id) .
                    '" class="btn btn-sm btn-info">View</a>
                    <a href="' .
                    route('checkin.print', $item->id) .
                    '"target="blank" class="btn btn-sm btn-info">Print</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.transaction.checkin.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Check In',
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
        return view('backend.transaction.checkin.create', [
            'counter' => $counter,
            'rooms' => Room::all(),
            'users' => User::all(),
            'title' => 'Tambah Check In',
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
            'guest_name' => 'required|max:255',
            'guest_job' => 'required|max:255',
            'marital_status' => 'required|max:255',
            'idcard_no' => 'required|max:255',
            'born_place' => 'required|max:255',
            'birth_date' => 'required|date',
            'transaction_date' => 'required|date',
            'checkin_date' => 'required|date',
            'room_id' => 'required|max:11',
            'user_id' => 'required|max:11',
            'duration' => 'required|max:11',
            'amount' => 'required',
            'idcard_image' => '',
            'guest_image' => '',
            'remark' => '',
            'created_by' => '',
        ]);
        $room = Room::find($request->room_id);

        $transNo = 'CI/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT);

        $validatedData['created_by'] = $idUser;
        $validatedData['room_price'] = $room->price;
        $validatedData['amount'] = (int) str_replace('.', '', $request->amount);
        $checkin = Checkin::create($validatedData);
        
        Log::create([
            'activity' => "$nameUser Membuat Checkin Atas Nama $request->guest_name Dengan Nomor $transNo",
            'created_by' => $idUser,
        ]);
        Transaction::create([
            'transaction_type' => 'Checkin',
            'guest_name' => $request->guest_name,
            'transaction_no' => $transNo,
            'date' => $request->transaction_date,
            'room_id' => $request->room_id,
            'amount' => $validatedData['amount'],
            'created_by' => $idUser,
        ]);
        // Use the checkin_date from the request to calculate the bill date
        $checkinDate = Carbon::parse($request->checkin_date);
        $billDate = $checkinDate->addMonths($request->duration); // Calculate the bill date based on checkin_date

        // dd($billDate);
        // Get the price of the room
        $price = $room ? $room->price : 0; // Default to 0 if room is not found

        Bill::create([
            'transaction_no' => 'B/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT),
            'bill_date' => $billDate, // Use the calculated bill date
            'guest_name' => $request->guest_name, // Use the calculated bill date
            'room_id' => $request->room_id, // Use the calculated bill date
            'amount' => $price, // Adjust this according to your billing logic
            'checkin_id' => $checkin->id, // Adjust this according to your billing logic
            'created_by' => $idUser,
        ]);
        Room::where('id', $request->room_id)->update(['is_available' => 0]);

        return redirect('/dashboard/checkin')->with('success', 'Transaksi Baru Telah Ditambahkan');
    }
    public function edit(Checkin $checkin)
    {
        $selectedRoomId = $checkin->room_id; // Get the room_id for the checkin
        $selectedUserId = $checkin->user_id; // Get the room_id for the checkin
        return view('backend.transaction.checkin.edit', [
            'item' => $checkin,
            'title' => 'Edit Check In',
            'rooms' => Room::all(),
            'users' => User::all(),
            'selectedRoomId' => $selectedRoomId,
            'selectedUserId' => $selectedUserId,
        ]);
    }

    public function update(Request $request)
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
            'guest_name' => 'required|max:255',
            'guest_job' => 'required|max:255',
            'marital_status' => 'required|max:255',
            'idcard_no' => 'required|max:255',
            'born_place' => 'required|max:255',
            'birth_date' => 'required|date',
            'transaction_date' => 'required|date',
            'checkin_date' => 'required|date',
            'room_id' => 'required|max:11',
            'user_id' => 'required|max:11',
            'duration' => 'required|max:11',
            'amount' => 'required',
            'idcard_image' => '',
            'guest_image' => '',
            'remark' => '',
            'created_by' => '',
        ]);
        $room = Room::find($request->room_id);
        $validatedData['room_price'] = $room->price;
        $validatedData['amount'] = (int) str_replace('.', '', $request->amount);
        Checkin::where('id', $request->id)->update($validatedData);

        // Update or create transaction
        Transaction::updateOrCreate(
            ['transaction_no' => $validatedData['transaction_no']], // Criteria to find existing record
            [
                'transaction_type' => 'Checkin',
                'guest_name' => $request->guest_name,
                'date' => $request->transaction_date,
                'room_id' => $request->room_id,
                'amount' => $validatedData['amount'],
                'created_by' => $idUser,
            ],
        );
        Room::where('id', $request->old_room_id)->update(['is_available' => 1]);
        Room::where('id', $request->room_id)->update(['is_available' => 0]);
        Log::create([
            'activity' => "$nameUser Mengubah Checkin Atas Nama $request->guest_name Dengan Nomor $request->transaction_no",
            'created_by' => $idUser,
        ]);
        // Use the checkin_date from the request to calculate the bill date
        $checkinDate = Carbon::parse($request->checkin_date);
        $billDate = $checkinDate->addMonths($request->duration); // Calculate the bill date based on checkin_date

        $room = Room::find($request->room_id);
        // Get the price of the room
        $price = $room ? $room->price : 0; // Default to 0 if room is not found
        // dd($billDate);
        Bill::updateOrCreate(
            ['checkin_id' => $request->id],
            [
                // Criteria to find existing record
                'bill_date' => $billDate, // Use the calculated bill date
                'transaction_no' => 'B/' . date('m/Y') . '/' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                'guest_name' => $request->guest_name, // Use the calculated bill date
                'room_id' => $request->room_id, // Use the calculated bill date
                'amount' => $price, // Adjust this according to your billing logic
                'created_by' => $idUser,
            ],
        );
        return redirect('/dashboard/checkin')->with('success', 'Transaksi Baru Telah Diubah');
    }

    public function show(Checkin $checkin)
    {
        return view('backend.transaction.checkin.detail', [
            'item' => $checkin,
            'title' => 'Detail Check In',
        ]);
    }

    public function print($id)
    {
        $checkin = Checkin::with(['user', 'room', 'bill'])->findOrFail($id); // Ambil data checkin dengan relasi room
        $pdf = App::make('dompdf.wrapper'); // Instansiasi DomPDF

        // Load view untuk PDF
        $pdf->loadView('backend.transaction.checkin.print', [
            'checkin' => $checkin,
            'title' => 'Cetak Check In',
        ])->setPaper('a4', 'portrait');
        // Stream PDF ke browser
        // return $pdf->stream('checkin-' . $checkin->id . '.pdf');
        return response($pdf->stream('checkin-' . $checkin->id . '.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="checkin-' . $checkin->id . '.pdf"');
    }

    public function destroy(Checkin $checkin)
    {
        $checkin = Checkin::findOrFail($checkin->id);
        $checkin->delete();

        return redirect('/dashboard/checkin')->with('success', 'Aset Telah Dihapus');
    }
}
