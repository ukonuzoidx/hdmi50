<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\HDshares;
use Illuminate\Http\Request;

class HDSharesController extends Controller
{
    public function index()
    {
        $page_title = 'HD Shares';
        $empty_message = 'No HD Shares found';
        // get all subscribed plans
        $hdshares = HDshares::paginate(getPaginate());
        $settings = GeneralSetting::first();
        return view('admin.hdshares.index', compact('page_title', 'hdshares', 'settings', 'empty_message'));
    }

    public function lockBuyShares(Request $request)
    {

        $general_setting = GeneralSetting::first();

        //update only h_dshares column in general setting table
        $general_setting->h_dshares = 1;
        $general_setting->save();



        $notify[] = ['success', 'HDShares locked successfully'];
        return back()->withNotify($notify);
    }
    public function openBuyShares(Request $request)
    {

        $general_setting = GeneralSetting::first();

        //update only h_dshares column in general setting table
        $general_setting->h_dshares = 0;
        $general_setting->save();



        $notify[] = ['success', 'HDShares Open successfully'];
        return back()->withNotify($notify);
    }
    public function lockSellShares(Request $request)
    {

        $general_setting = GeneralSetting::first();

        //update only h_sell_dshares column in general setting table
        $general_setting->h_sell_dshares = 1;
        $general_setting->save();



        $notify[] = ['success', 'HDShares locked successfully'];
        return back()->withNotify($notify);
    }
    public function openSellShares(Request $request)
    {

        $general_setting = GeneralSetting::first();

        //update only h_sell_dshares column in general setting table
        $general_setting->h_sell_dshares = 0;
        $general_setting->save();



        $notify[] = ['success', 'HDShares Open successfully'];
        return back()->withNotify($notify);
    }
}
