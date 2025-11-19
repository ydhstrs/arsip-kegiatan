<?php

namespace App\Http\Controllers\Master;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Asset;

class AssetController extends Controller
{

     public function getData(Request $request)
    {
        $items = Asset::select(['id', 'name', 'buying_date', 'buying_price', 'created_at'])->get();
        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a href="'.route('asset.edit', $item->id).'" class="btn btn-sm btn-primary">Edit</a>
                        <a href="'.route('asset.show', parameters: $item->id).'" class="btn btn-sm btn-info">View</a>
                        <form action="'.route('asset.destroy', $item->id).'" method="POST" style="display:inline;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index(): View
    {
        return view('backend.master.asset.index', [
            // 'items' => Room::latest()->paginate(10),
            'title' => 'Aset',
        ]);
    }

    public function create(): View
    {
        return view('backend.master.asset.create', [
            // 'charges' => ChargeType::all(),
            'title' => 'Tambah Aset',
        ]);
    }
    public function store(Request $request)
    {
        // echo $request;
        $validatedData = $request->validate([
            'name' => 'required|max:11',
            'buying_date' => 'required|date',
            'buying_price' => 'required',
            'image' => '',
            'remark' => '',
        ]);

         $validatedData['buying_price'] = (int) str_replace('.', '', $request->buying_price);
        Asset::create($validatedData);

        return redirect('/dashboard/asset')->with('success', 'Asset Baru Telah Ditambahkan');
    }
    public function edit(Asset $asset)
    {
        return view('backend.master.asset.edit', [
            'item' => $asset,
            'title' => 'Edit Kamar',
        ]);
    }

    public function update(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:11',
            'buying_date' => 'required|date',
            'buying_price' => 'required',
            'image' => '',
            'remark' => '',
        ]);
         $validatedData['buying_price'] = (int) str_replace('.', '', $request->buying_price);

        Asset::where('id', $asset->id)->update($validatedData);

        return redirect('/dashboard/asset')->with('success', 'Aset Telah Diedit');
    }

    public function show(Asset $asset)
    {
        return view('backend.master.asset.detail', [
            'item' => $asset,
            'title' => 'Detail Aset',
        ]);
    }
    public function destroy(Asset $asset)
    {
        $asset = Asset::findOrFail($asset->id);
        $asset->delete();

        return redirect('/dashboard/asset')->with('success', 'Aset Telah Dihapus');

    }
}
