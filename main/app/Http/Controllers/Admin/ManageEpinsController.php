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
        $request->validate([
            'sponsorId' => 'required',
        ]);

        // check if sponsor id is valid
        $sponsor = \App\Models\User::where('user_id', $request->sponsorId)->first();
        if (!$sponsor) {
            $notify[] = ['error', 'Sponsor id is not valid'];
            return back()->withNotify($notify);
        }
        $status = 0;
   
        // create epin by the total number of total pin put
        for ($i = 0; $i < $request->total; $i++) {
           $epin= Epin::create([
                'epin' => generateRandomString(8),
                'status' => $status,
                'user_id' => $sponsor->id,
                'type' => $request->type,
            ]);
        }
        $epin;
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
