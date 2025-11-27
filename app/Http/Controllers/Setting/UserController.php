<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
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
            'email_verified_at' => '2025-11-27 10:46:03',
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
            'roles' => Role::all(),
            'title' => 'Edit User',
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'nullable|min:6', // password opsional
        ]);
    
        // Update data dasar
        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            // hanya update password kalau diisi
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);
    
        // Update Role dengan Spatie
        $user->syncRoles([$request->role]);
    
        return redirect('/dashboard/user')->with('success', 'User Telah Diedit');
    }
    

    public function show(User $user)
    {

    }

    public function destroy(User $user)
    {
        $room = User::findOrFail($user->id);
        $room->delete();

        return redirect('/dashboard/user')->with('success', 'User Telah Dihapus');

    }
}
