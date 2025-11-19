<?php

namespace App\Http\Controllers\Master;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Room;

class RoomController extends Controller
{

     public function getData(Request $request)
    {
        $rooms = Room::select(['id', 'name', 'type', 'floor', 'price','is_available', 'created_at'])->get();
        return DataTables::of($rooms)
            ->addColumn('action', function ($room) {
                return '<a href="'.route('room.edit', $room->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="'.route('room.show', $room->id).'" class="btn btn-sm btn-info">View</a>
                        <form action="'.route('room.destroy', $room->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.master.room.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Kamar',
        ]);
    }

    public function create(): View
    {
        return view('backend.master.room.create', [
            // 'charges' => ChargeType::all(),
            'title' => 'Tambah Kamar',
        ]);
    }
    public function store(Request $request)
    {
        // echo $request;
        $validatedData = $request->validate([
            'name' => 'required|max:11',
            'type' => 'required|max:255',
            'image' => '',
            'floor' => 'max:11',
            'price' => 'required',
            'remark' => '',
        ]);
         $validatedData['price'] = (int) str_replace('.', '', $request->price);

        Room::create($validatedData);

        return redirect('/dashboard/room')->with('success', 'Kamar Baru Telah Ditambahkan');
    }
    public function edit(Room $room)
    {
        return view('backend.master.room.edit', [
            'item' => $room,
            'title' => 'Edit Kamar',
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:11',
            'type' => 'required|max:255',
            'image' => '',
            'price' => 'required',
            'floor' => 'max:11',
            'remark' => '',
        ]);
         $validatedData['price'] = (int) str_replace('.', '', $request->price);
        Room::where('id', $room->id)->update($validatedData);

        return redirect('/dashboard/room')->with('success', 'Room Telah Diedit');
    }

    public function show(Room $room)
    {
        return view('backend.master.room.detail', [
            'item' => $room,
            'title' => 'Detail Kamar',
        ]);
    }
    public function destroy(Room $room)
    {
        $room = Room::findOrFail($room->id);
        $room->delete();

        return redirect('/dashboard/room')->with('success', 'Room Telah Dihapus');

    }
}
