<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epin;
use Illuminate\Http\Request;

class ManageEpinsController extends Controller
{
    public function allEpins()
    {
        $page_title = 'Manage Epins';
        $empty_message = 'No epin found';
        $epins = Epin::latest()->paginate(getPaginate());
        return view('admin.epins.index', compact('page_title', 'empty_message', 'epins'));
    }

    public function usedEpins()
    {
        $page_title = 'Used Epins';
        $empty_message = 'No used epin found';
        $epins = Epin::used()->latest()->paginate(getPaginate());
        return view('admin.epins.index', compact('page_title', 'empty_message', 'epins'));
    }

    public function unusedEpins()
    {
        $page_title = 'Unused Epins';
        $empty_message = 'No unused epin found';
        $epins = Epin::unused()->latest()->paginate(getPaginate());
        return view('admin.epins.index', compact('page_title', 'empty_message', 'epins'));
    }

    public function epinStore(Request $request)
    {
        $this->validate($request, [
            'epin'              => 'required|unique:epins',
            'amount'            => 'required|numeric|min:0',
        ]);

        $status = 0;

        $epin = new Epin();
        $epin->epin             = $request->epin;
        $epin->amount           = $request->amount;
        $epin->status           = $status;
        $epin->save();

        $notify[] = ['success', 'New Epin created successfully'];
        return back()->withNotify($notify);
    }

    public function epinUpdate(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'id'                => 'required',
            'epin'              => 'required',
            'amount'            => 'required|numeric|min:0',
            'status'           => 'required',
        ]);

        $epin                   = Epin::find($request->id);
        $epin->epin             = $request->epin;
        $epin->amount           = $request->amount;
        $epin->status           = $request->status ? 1 : 0;
        $epin->save();

        $notify[] = ['success', 'Epin updated successfully'];
        return back()->withNotify($notify);
    }
}
