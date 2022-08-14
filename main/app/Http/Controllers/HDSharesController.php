<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\HDshares;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class HDSharesController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'HD Shares';
        $empty_message = 'No HD Shares found';
        // get all hd shares for the current user
        $hd_shares = HDshares::paginate(getPaginate());
        $settings = GeneralSetting::first();
        return view($this->activeTemplate . 'user.hdshares', compact('page_title', 'hd_shares', 'settings', 'empty_message'));
    }

    public function buyShares(Request $request)
    {
        $this->validate($request, [
            'price' => 'required|integer|min:1',
        ]);
        /**
         * each share cost $1/10 units
         */
        $user = Auth::user();
        $price = $request->price;
        $userId = $user->id;
        $units = $price * 10;



        /**users can top up their account with $1/10 units
         * the price should not be less than $100
         */
        if ($price < 100) {
            $notify[] = ['error', 'The price should not be less than $100'];
            return back()->withNotify($notify);
        }

        /**
         * check if the user has enough balance to buy the shares
         */
        if ($user->balance < $price) {
            $notify[] = ['error', 'You do not have enough balance to buy the shares'];
            return back()->withNotify($notify);
        }
        /**
         * check if the user has already bought the shares
         * if yes, update the quantity
         * if no, create a new record
         */
        $hd_share = HDshares::where('user_id', $userId)->first();
        if ($hd_share) {
            $user->balance -= $price;
            $user->save();
            $hd_share->units += $units;
            $hd_share->save();
        } else {
            $user->balance -= $price;
            $user->save();

            $hd_share = new HDshares();
            $hd_share->user_id = $userId;
            $hd_share->name = "Bought";
            $hd_share->units = $units;
            $hd_share->save();
        }


        $notify[] = ['success', 'HD Shares purchased successfully'];
        return back()->withNotify($notify);
    }

    public function sellShares(Request $request)
    {

        // dd($request->all());
        /**
         * check percentage of shares
         * if 25% sell 25% of shares and update the balance
         * if 50% sell 50% of shares and update the balance
         * if 75% sell 75% of shares and update the balance
         * if 100% sell 100% of shares and update the balance
         */
        $user = Auth::user();
        $id = $request->id;
        $userId = $user->id;
        // convert the units to percentage
        $units = $request->units;
        $units = $units / 100;

        // dd($units);

        $hd_share = HDshares::where('id', $id)->first();
        // check if the user has enough shares to sell
        if ($hd_share->units == 0) {
            $notify[] = ['error', 'You do not have enough shares to sell'];
            return back()->withNotify($notify);
        }

        $units_sold = $hd_share->units * $units;
        $units_user_sold = $hd_share->units / 10 * $units;
        // dd($units_sold);
        $hd_share->units -= $units_sold;
        $hd_share->save();

        $user->balance += $units_user_sold;
        $user->save();


        $notify[] = ['success', 'HD Shares sold successfully'];
        return back()->withNotify($notify);
    }
}