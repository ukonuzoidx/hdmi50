<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalAssets;
use Illuminate\Http\Request;


class DigitalAssetController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Digital Assets';
        $data['digital_assets'] = DigitalAssets::paginate(getPaginate());
        $data['empty_message'] = 'No Digital Assets Found';
        return view('admin.digital_assets.index', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:digital_assets',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('images/digital_assets'), $imageName);

        $digitalAsset = new DigitalAssets();
        $digitalAsset->name = $request->name;
        $digitalAsset->description = $request->description;
        $digitalAsset->image = $imageName;
        $digitalAsset->save();

        return redirect()->route('admin.digital_assets.index')->with('success', 'Digital Asset created successfully');
    }
}
