<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\SubscribedPlans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MlmController extends Controller
{
    public function plan()
    {
        $page_title = 'MLM Plans';
        $empty_message = 'No Plan found';
        // get all subscribed plans
        $subscribed_plans = SubscribedPlans::all();
        $subscribed = "Subscribed Plans List";
        $empty_subscribed_message = 'No Subscribed Plans Found';
        $plans = Plan::paginate(getPaginate());
        return view('admin.plan.index', compact('page_title', 'plans', 'subscribed_plans', 'subscribed', 'empty_subscribed_message', 'empty_message'));
    }

    public function planStore(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required',
            'price'             => 'required|numeric|min:0',
            'pv'                => 'required|min:0|integer',
            'ref_com'           => 'required|numeric|min:0',
            'tree_com'          => 'required|numeric|min:0',
            'roi'               => 'required|numeric|min:0',
        ]);


        $plan = new Plan();
        $plan->name             = $request->name;
        $plan->price            = $request->price;
        $plan->pv               = $request->pv;
        $plan->ref_com          = $request->ref_com;
        $plan->tree_com         = $request->tree_com;
        $plan->roi              = $request->roi;
        $plan->status           = $request->status ? 1 : 0;
        $plan->save();

        $notify[] = ['success', 'New Plan created successfully'];
        return back()->withNotify($notify);
    }

    public function planUpdate(Request $request)
    {
        $this->validate($request, [
            'id'                => 'required',
            'name'              => 'required',
            'price'             => 'required|numeric|min:0',
            'pv'                => 'required|min:0|integer',
            'ref_com'           => 'required|numeric|min:0',
            'tree_com'          => 'required|numeric|min:0',
            'roi'               => 'required|numeric|min:0',
        ]);

        $plan                   = Plan::find($request->id);
        $plan->name             = $request->name;
        $plan->price            = $request->price;
        $plan->pv               = $request->pv;
        $plan->ref_com          = $request->ref_com;
        $plan->tree_com         = $request->tree_com;
        $plan->roi              = $request->roi;
        $plan->status           = $request->status ? 1 : 0;
        $plan->save();

        $notify[] = ['success', 'Plan Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function matchingUpdate(Request $request)
    {
        $this->validate($request, [
            'pv_price' => 'required|min:0',
            'total_pv' => 'required|min:0|integer',
            'max_pv' => 'required|min:0|integer',
        ]);

        $setting = GeneralSetting::first();

        // dd($setting, $request->all());
        if ($request->matching_bonus_time == 'daily') {
            $when = $request->daily_time;
        } elseif ($request->matching_bonus_time == 'weekly') {
            $when = $request->weekly_time;
        } elseif ($request->matching_bonus_time == 'monthly') {
            $when = $request->monthly_time;
        }


        $setting->pv_price = $request->pv_price;
        $setting->total_pv = $request->total_pv;
        $setting->max_pv = $request->max_pv;
        $setting->cary_flash = $request->cary_flash;
        $setting->matching_bonus_time = $request->matching_bonus_time;
        $setting->matching_when = $when;
        $setting->save();

        $notify[] = ['success', 'Matching bonus has been updated.'];
        return back()->withNotify($notify);
    }

    // roi update in general settings
    public function roiUpdate(Request $request)
    {
        $this->validate($request, [
            'roi_bonus_time' => 'required',
        ]);

        $setting = GeneralSetting::first();
        if ($request->roi_bonus_time == 'daily') {
            $when = $request->daily_time ;
        } elseif ($request->roi_bonus_time == 'weekly') {
            $when = $request->weekly_time;
        } elseif ($request->roi_bonus_time == 'monthly') {
            $when = $request->monthly_time;
        }

        $setting->roi_bonus_time = $request->roi_bonus_time;
        $setting->roi_when = $when;
        $setting->roi_when_time = Carbon::createFromFormat('H', $when)->format('Y-m-d H:i:s');
        $setting->save();

        $notify[] = ['success', 'ROI has been updated.'];
        return back()->withNotify($notify);
    }
}
