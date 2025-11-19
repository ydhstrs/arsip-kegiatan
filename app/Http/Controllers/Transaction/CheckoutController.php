<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Checkin;
use App\Models\Transaction;
use App\Models\Log;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Checkout;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function getData(Request $request)
    {
        $items = Checkout::select(['checkouts.id', 'checkouts.checkout_date', 'rooms.name as room_name', 'checkouts.created_at'])
            ->join('rooms', 'checkouts.room_id', '=', 'rooms.id')
            ->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '
                    <form action="' .
                    route('asset.destroy', $item->id) .
                    '" method="POST" style="display:inline;">
                        ' .
                    csrf_field() .
                    method_field('DELETE') .
                    '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.transaction.checkout.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Check Out',
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
        return view('backend.transaction.checkout.create', [
            'counter' => $counter,
            'rooms' => Room::all(),
            'title' => 'Tambah Check Out',
        ]);
    }
    public function store(Request $request)
    {


        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        $validatedData = $request->validate([
            'checkout_date' => 'required|date',
            'room_id' => 'required|max:11',
            'remark' => '',
            'created_by' => '',
        ]);
        $validatedData['created_by'] = $idUser;

        Checkout::create($validatedData);
        Room::where('id', $request->room_id)->update(['is_available' => 1]);
        Log::create([
            'activity' => "$nameUser Membuat Checkout Atas Nama $request->guest_name",
            'created_by' => $idUser,
        ]);
        $bill = Bill::findOrFail($request->room_id);
        $bill->delete();

        return redirect('/dashboard/checkout')->with('success', 'Checkout Berhasil Dibuat');
    }

    public function show(Checkin $checkin)
    {
        return view('backend.transaction.checkout.detail', [
            'item' => $checkin,
            'title' => 'Detail Check Out',
        ]);
    }
}
