<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getData(Request $request)
    {
        $users = User::select(['id', 'name', 'username', 'email', 'created_at'])->get();

        return DataTables::of($users)
            ->addColumn('action', function ($item) {
                return '<a href="'.route('user.edit', $item->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <form action="'.route('user.destroy', $item->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index(): View
    {
        return view('backend.setting.user.index', [
            // 'items' => User::latest()->paginate(10),
            'title' => 'Akun',
        ]);
    }

    public function create(): View
    {
        return view('backend.setting.user.create', [
            // 'charges' => ChargeType::all(),
            'title' => 'Tambah Pengguna',
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign Role
        $user->assignRole($request->role);

        return redirect('/dashboard/user')->with('success', 'User Baru Telah Ditambahkan');
    }

    public function edit(User $user)
    {
        return view('backend.setting.user.edit', [
            'item' => $user,
            'title' => 'Edit User',
        ]);
    }

    public function update(Request $request, User $room)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:11',
            'username' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        User::where('id', $room->id)->update($validatedData);

        return redirect('/dashboard/room')->with('success', 'User Telah Diedit');
    }

    public function show(User $user)
    {
        return view('backend.setting.user.detail', [
            'item' => $user,
            'title' => 'Detail Akun',
        ]);
    }

    public function destroy(User $user)
    {
        $room = User::findOrFail($user->id);
        $room->delete();

        return redirect('/dashboard/user')->with('success', 'User Telah Dihapus');

    }
}
