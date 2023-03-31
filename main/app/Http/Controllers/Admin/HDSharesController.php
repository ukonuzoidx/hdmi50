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

    /**
     * get all users who have hd shares and claim it
     */
    public function claimAllShares()
    {

        $hdshares = HDshares::all();
        $settings = GeneralSetting::first();
        foreach ($hdshares as $hdshare) {
            $user = $hdshare->user;
            // add capital plus profit and loss
            // $capital = $hdshare->capital;
            // $units = $hdshare->units;
            // $new_capital = $hdshare->capital + ($hdshare->capital * $settings->pnl) / 100;
            // $balance = $new_capital;

            $profit = ($user->hdShares->pluck('capital')->first() * $settings->pnl) / 100;


            $capital = $hdshare->capital - $profit;
            $units_user_sold = $capital * 10;
            $balance = $profit;






            $user->balance += $balance;
            $user->save();
            $hdshare->capital -= $profit;
            $hdshare->units -= $units_user_sold;
            $hdshare->save();
            // $hdshare->delete();
        }
        // foreach ($hdshares as $hdshare) {
        //     $user = $hdshare->user;
        //     $user->balance += $hdshare->units;
        //     $user->save();
        //     $hdshare->delete();
        // }

        $notify[] = ['success', 'All HDShares claimed successfully'];
        return back()->withNotify($notify);
    }
}
