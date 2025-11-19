<?php

namespace App\Http\Controllers\Setting;

use App\Models\RoomMove;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Log;
use App\Models\Bill;

class RoomMoveController extends Controller
{
    public function getData(Request $request)
    {
        $items = RoomMove::select(['room_moves.id', 'room_moves.guest_name', 'a.name as from_room', 'b.name as to_room', 'room_moves.move_date'])
            ->join('rooms as a', 'room_moves.from_room_id', '=', 'a.id')
            ->join('rooms as b', 'room_moves.to_room_id', '=', 'b.id')
            ->get();

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a href="' .
                    route('roommove.edit', $item->id) .
                    '" class="btn btn-sm btn-primary">Edit</a>
                        <a href="';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.setting.roommove.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Pindah Kamar',
        ]);
    }

    public function create(): View
    {
        $occupiedRooms = Room::select('rooms.*', 'bills.guest_name')->join('bills', 'rooms.id', '=', 'bills.room_id')->get();
        $freeRooms = Room::where('is_available', 1)->get();
        return view('backend.setting.roommove.create', [
            'freeRooms' => $freeRooms,
            'occupiedRooms' => $occupiedRooms,
            'title' => 'Pindah Kamar',
        ]);
    }
    public function store(Request $request)
    {
        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        $fromRoom = Room::find($request->from_room_id);
        $oldRoom = $fromRoom->name;

        $toRoom = Room::find($request->to_room_id);
        $newRoom = $toRoom->name;
        // echo $request;
        $validatedData = $request->validate([
            'from_room_id' => 'required|max:11',
            'to_room_id' => 'required|max:11',
            'guest_name' => '',
            'move_date' => 'required|date',
            'remark' => '',
        ]);
        $validatedData['created_by'] = $idUser;

        RoomMove::create($validatedData);

        Log::create([
            'activity' => "$nameUser Memindahkan Kamar $request->guest_name Dari  $oldRoom Ke $newRoom",
            'created_by' => $idUser,
        ]);
     

        Room::where('id', $request->from_room_id)->update(['is_available' => 1]);
        Room::where('id', $request->to_room_id)->update(['is_available' => 0]);
        Bill::where('room_id', $request->from_room_id)
            ->where('guest_name', $request->guest_name)
            ->where('payment_date', null)
            ->update(['room_id' => $request->to_room_id]);

        return redirect('/dashboard/roommove')->with('success', 'Kamar Telah Dipindahkan');
    }
    public function edit(RoomMove $roomMove)
    {
        return view('backend.transaction.roommove.edit', [
            'item' => $roomMove,
            'title' => 'Edit Pindah Kamar',
        ]);
    }

    public function update(Request $request, RoomMove $roomMove)
    {
        $idUser = Auth::id();
        $nameUser = Auth::user()->name;

        // Validate the incoming request
        $validatedData = $request->validate([
            'from_room_id' => 'required|max:11',
            'to_room_id' => 'required|max:255',
            'guest_name' => '',
            'move_date' => 'required|date',
            'remark' => '',
        ]);

        // Retrieve the old room details before updating
        $fromRoom = Room::find($request->from_room_id);
        $oldRoom = $fromRoom->name;

        $toRoom = Room::find($request->to_room_id);
        $newRoom = $toRoom->name;
        RoomMove::where('id', $roomMove->id)->update($validatedData);

        // Log the activity
        Log::create([
            'activity' => "$nameUser Memindahkan Kamar $request->guest_name Dari  $oldRoom Ke $newRoom",
            'created_by' => $idUser,
        ]);

        // Update the room availability status
        Room::where('id', $request->from_room_id)->update(['is_available' => 0]);
        Room::where('id', $request->to_room_id)->update(['is_available' => 1]);

        Bill::where('room_id', $request->from_room_id)
            ->where('guest_name', $request->guest_name)
            ->where('payment_date', null)
            ->update(['room_id' => $request->to_room_id]);

        return redirect('/dashboard/roommove')->with('success', 'Kamar Telah Dipindahkan');
    }

    public function show(RoomMove $roomMove)
    {
        return view('backend.transaction.roommove.show', [
            'item' => $roomMove,
            'title' => 'Detail Kamar',
        ]);
    }
    public function destroy(RoomMove $roomMove)
    {
        $room = Room::findOrFail($roomMove->id);
        $room->delete();

        return redirect('/dashboard/room')->with('success', 'Room Telah Dihapus');
    }
}
