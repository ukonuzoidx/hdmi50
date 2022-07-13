<?php

namespace App\Http\Controllers;

use App\Models\DigitalAssets;
use App\Models\Epin;
use App\Models\FixedInvestment;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\PvLog;
use App\Models\Roi;
use App\Models\SubscribedPlans;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    public function index()
    {
        $data['plans'] = Plan::whereStatus(1)->get();
        // get all subscribed plans
        $data['subscribed_plans'] = SubscribedPlans::whereUserId(Auth::user()->id)->get();
        $data['subscribed'] = "Subscribed Plans List";
        $data['empty_message'] = "No Subscribed Plans Found";
        // dd($data);

        $data['page_title'] = "Plans";
        return view($this->activeTemplate . 'user.plans', $data);
    }

    public function fixedInvestment()
    {
        $data['fixedInvestment'] = FixedInvestment::whereStatus(1)->get();

        $data['page_title'] = "Fixed Investment";
        return view($this->activeTemplate . 'user.fixedInvestment', $data);
    }
    public function pvlog(Request $request)
    {

        if ($request->type) {
            if ($request->type == 'leftPV') {
                $data['page_title'] = "Left PV";
                $data['logs'] = PvLog::where('user_id', auth()->id())->where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->paginate(10);
            } elseif ($request->type == 'rightPV') {
                $data['page_title'] = "Right PV";
                $data['logs'] = PvLog::where('user_id', auth()->id())->where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->paginate(10);
            } elseif ($request->type == 'cutPV') {
                $data['page_title'] = "Cut PV";
                $data['logs'] = PvLog::where('user_id', auth()->id())->where('trx_type', '-')->orderBy('id', 'desc')->paginate(10);
            } else {
                $data['page_title'] = "All Paid PV";
                $data['logs'] = PvLog::where('user_id', auth()->id())->where('trx_type', '+')->orderBy('id', 'desc')->paginate(10);
            }
        } else {
            $data['page_title'] = "PV LOG";
            $data['logs'] = PvLog::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(10);
        }

        $data['empty_message'] = 'No data found';
        return view($this->activeTemplate . "user.pvlog", $data);
    }

    function fixedInvestmentStore(Request $request)
    {
        $this->validate($request, ['fixed_investment_id' => 'required|integer']);
        $fixedInvestment = FixedInvestment::where('id', $request->fixed_investment_id)->where('status', 1)->firstOrFail();
        $gnl = GeneralSetting::first();

        $user = User::find(Auth::id());
        // decrypt pin
        $pin = Hash::check($request->pin, $user->pin);


        if ($user->balance < $fixedInvestment->price) {
            $notify[] = ['error', 'Insufficient Balance'];
            return back()->withNotify($notify);
        }
        if (!$pin) {
            $notify[] = ['error', 'Invalid Pin'];
            return back()->withNotify($notify);
        }


        // $oldPlan = $user->plan_id;
        $user->balance -= $fixedInvestment->price;
        $user->total_invest += $fixedInvestment->price;
        // $user->roi += $fixedInvestment->roi;
        // $user->balance += $fixedInvestment->roi;
        $user->save();


        $roi = Roi::create([
            'user_id' => $user->id,
            'plan_id' => $fixedInvestment->id,
            'roi' => $fixedInvestment->fixed_roi,
            'remark' => 'fixed_investment',
            // 'roi_last_paid' => date('Y-m-d H:i:s'),
        ]);

        $roi->roi_last_paid = Carbon::now()->addDays(400);
        $roi->roi_last_cron = Carbon::now();
        $roi->save();

        $trx = $user->transactions()->create([
            'amount' => $fixedInvestment->price,
            'trx_type' => '-',
            'details' => 'Purchased ' . $fixedInvestment->name,
            'charge' => $fixedInvestment->charge,
            'remark' => 'purchased_plan',
            'trx' => getTrx(),
            'post_balance' => getAmount($user->balance),
        ]);

        notify($user, 'plan_purchased', [
            'plan' => $fixedInvestment->name,
            'amount' => getAmount($fixedInvestment->price),
            'currency' => $gnl->cur_text,
            'trx' => $trx->trx,
            'post_balance' => getAmount($user->balance) . ' ' . $gnl->cur_text,
        ]);

        $details = Auth::user()->username . ' Subscribed to ' . $fixedInvestment->name . ' plan.';

        $notify[] = ['success', 'Purchased ' . $fixedInvestment->name . ' Successfully'];
        return redirect()->route('user.home')->withNotify($notify);
    }

    function planStore(Request $request)
    {
        $this->validate($request, ['plan_id' => 'required|integer']);
        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->firstOrFail();
        $gnl = GeneralSetting::first();

        $user = User::find(Auth::id());


        // dd($request->type);

        if ($request->type == "flexible") {
            // decrypt pin
            $pin = Hash::check($request->pin, $user->pin);


            if ($user->balance < $plan->price) {
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }
            if (!$pin) {
                $notify[] = ['error', 'Invalid Pin'];
                return back()->withNotify($notify);
            }

            $subscribed = SubscribedPlans::create([
                'user_id'  => $user->id,
                'plan_id'  => $plan->id,
                'amount'   => $plan->price,
                'pv'       => $plan->pv,
                'ref_com'  => $plan->ref_com,
                'tree_com' => $plan->tree_com,
                'subscribed_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+12 months')),
            ]);


            $user->balance -= $plan->price;
            $user->total_invest += $plan->price;
            $user->save();


            $roi = Roi::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'roi' => $plan->roi,
                'remark' => 'plan_purchased',
                'roi_last_paid' => date('Y-m-d H:i:s'),
            ]);

            $trx = $user->transactions()->create([
                'amount' => $plan->price,
                'trx_type' => '-',
                'details' => 'Purchased ' . $plan->name,
                'remark' => 'purchased_plan',
                'trx' => getTrx(),
                'post_balance' => getAmount($user->balance),
            ]);

            notify($user, 'plan_purchased', [
                'plan' => $plan->name,
                'amount' => getAmount($plan->price),
                'currency' => $gnl->cur_text,
                'trx' => $trx->trx,
                'post_balance' => getAmount($user->balance) . ' ' . $gnl->cur_text,
            ]);

            $details = Auth::user()->username . ' Subscribed to ' . $plan->name . ' plan.';

            updatePV($user->id, $plan->pv, $details);
            referralCommission($user->id, $details, $plan->id);
            matchingPVBonus($user->id, $plan->pv, $details);

            // create the digital assets for the user

            $digitalAssets = DigitalAssets::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'type' => 'plan',
                'name' => $plan->name,
                'description' => $plan->name,
                'current_price' => $plan->price,
                'total_product' => $plan->total_product,
                'claim' => $plan->claim,
            ]);
        } else {
            // decrypt pin
            $pin = Hash::check($request->pin, $user->pin);


            if ($user->balance < $plan->price) {
                $notify[] = ['error', 'Insufficient Balance'];
                return back()->withNotify($notify);
            }
            if (!$pin) {
                $notify[] = ['error', 'Invalid Pin'];
                return back()->withNotify($notify);
            }

            $subscribed = SubscribedPlans::create([
                'user_id'  => $user->id,
                'plan_id'  => $plan->id,
                'amount'   => $plan->price,
                'pv'       => $plan->pv,
                'ref_com'  => $plan->ref_com,
                'tree_com' => $plan->tree_com,
                'subscribed_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+12 months')),
            ]);

            $user->balance -= $plan->price;
            $user->total_invest += $plan->price;
            $user->save();


            $roi = Roi::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'roi' => $plan->roi,
                'remark' => 'fixed_investment',
            ]);
            $roi->roi_last_paid = Carbon::now()->addDays(400);
            $roi->roi_last_cron = Carbon::now();
            $roi->save();

            $trx = $user->transactions()->create([
                'amount' => $plan->price,
                'trx_type' => '-',
                'details' => 'Purchased ' . $plan->name,
                'remark' => 'purchased_plan',
                'trx' => getTrx(),
                'post_balance' => getAmount($user->balance),
            ]);

            notify($user, 'plan_purchased', [
                'plan' => $plan->name,
                'amount' => getAmount($plan->price),
                'currency' => $gnl->cur_text,
                'trx' => $trx->trx,
                'post_balance' => getAmount($user->balance) . ' ' . $gnl->cur_text,
            ]);

            $details = Auth::user()->username . ' Subscribed to ' . $plan->name . ' plan.';

            updatePV($user->id, $plan->pv, $details);
            referralCommission($user->id, $details, $plan->id);
            matchingPVBonus($user->id, $plan->pv, $details);

            // create the digital assets for the user

            $digitalAssets = DigitalAssets::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'type' => 'plan',
                'name' => $plan->name,
                'description' => $plan->name,
                'current_price' => $plan->price,
                'total_product' => $plan->total_product,
                'claim' => $plan->claim,
            ]);
        }










        $notify[] = ['success', 'Purchased ' . $plan->name . ' Successfully'];
        return redirect()->route('user.home')->withNotify($notify);
    }


    public function myRefLog()
    {
        $data['page_title'] = "My Referral";
        $data['empty_message'] = 'No data found';
        $data['logs'] = User::where('ref_id', auth()->id())->latest()->paginate(10);
        return view($this->activeTemplate . 'user.myRef', $data);
    }
    public function myTree()
    {
        // $data['tree'] = User::find(auth()->user()->id);
        $data['tree'] = showTreePage(Auth::id());
        $data['page_title'] = "My Tree";
        // dd($data['tree']);
        return view($this->activeTemplate . 'user.myTree', $data);
    }


    public function otherTree(Request $request, $username = null)
    {
        if ($request->username) {
            $user = User::where('username', $request->username)->first();
        } else {
            $user = User::where('username', $username)->first();
        }
        // dd($user->id);
        if ($user && treeAuth($user->id, auth()->user()->id)) {

            // $data['tree'] = User::find($user->id);
            $data['tree'] = showTreePage($user->id);
            $data['page_title'] = "Tree of " . $user->fullname;
            return view($this->activeTemplate . 'user.myTree', $data);
            // dd($data['tree']);
        }

        $notify[] = ['error', 'Tree Not Found or You do not have Permission to view that!!'];
        return redirect()->route('user.my.tree')->withNotify($notify);
    }
    // public function binaryCom()
    // {
    //     $data['page_title'] = "Binary Commission";
    //     $data['logs'] = Transaction::where('user_id', auth()->id())->where('remark', 'binary_commission')->orderBy('id', 'DESC')->paginate(config('constants.table.default'));
    //     $data['empty_message'] = 'No data found';
    //     return view($this->activeTemplate . '.user.transactions', $data);
    // }

    public function binarySummary()
    {
        $data['page_title'] = "Binary Summery";
        $data['logs'] = UserExtra::where('user_id', auth()->id())->firstOrFail();
        return view($this->activeTemplate . 'user.binarySummary', $data);
    }

    public function claimRoi(Request $request)
    {
        $user = User::find(Auth::id());
        $roi = Roi::where('user_id', $user->id)->where('remark', 'plan_purchased')->get();
        $gnl = GeneralSetting::first();

        // check the difference between current time and created time
        // if the difference is less than 24 hours, then it is not possible to claim the roi
        foreach ($roi as $key => $value) {
            // $now = $gnl->roi_when_time;
            // $diff = strtotime($value->roi_last_cron) - strtotime($value->roi_last_paid);
            // $diff = $diff / (60 * 60);
            // if ($value->roi_last_cron == null) {
            //     // check the difference between current time and roi_last_paid if the difference is less than 24 hours, then it is not possible to claim the roi
            $now = Carbon::now();
            $diff = strtotime($now) - strtotime($value->roi_last_paid);
            $diff = $diff / (60 * 60);

            if ($diff > 24) {
                $user->balance += $value->roi;
                $user->roi += $value->roi;
                $user->save();
                $value->roi_last_paid = Carbon::now();
                $value->save();
                $notify[] = ['success', 'ROI Claimed Successfully'];
                return  redirect()->route('user.home')->withNotify($notify);
            } else {
                $notify[] = ['error', 'You can not claim the ROI now!!'];
                return redirect()->route('user.home')->withNotify($notify);
            }
        }
    }
    public function claimFixedRoi(Request $request)
    {
        $user = User::find(Auth::id());
        $roi = Roi::where('user_id', $user->id)->where('remark', 'fixed_investment')->get();
        $gnl = GeneralSetting::first();

        foreach ($roi as $key => $value) {
            $now = Carbon::now();
            $diff = strtotime($now) - strtotime($value->roi_last_cron);
            $diff = $diff / (60 * 60);

            // dd($diff);

            if ($diff > 24) {
                $user->fixed_roi += $value->roi;
                $user->save();
                $value->roi_last_cron = Carbon::now();
                $value->save();
                $notify[] = ['success', 'Fixed ROI Claimed Successfully'];
                return  redirect()->route('user.home')->withNotify($notify);
            } else {
                $notify[] = ['error', 'You can not claim the ROI now!!'];
                return redirect()->route('user.home')->withNotify($notify);
            }
        }
    }

    public function withdrawFixedRoi(Request $request)
    {
        $user = User::find(Auth::id());
        $roi = Roi::where('user_id', $user->id)->where('remark', 'fixed_investment')->get();
        $gnl = GeneralSetting::first();

        foreach ($roi as $key => $value) {
            $now = Carbon::now();
            $withdrawDate = Carbon::parse($value->roi_last_paid);
            // $diff = strtotime($now) - strtotime($withdrawDate);
            $diff = strtotime($withdrawDate) - strtotime($now);
            $diff = $diff / (60 * 60);

            // dd($diff);

            if ($diff > 9600) {
                if ($user->fixed_roi < 0) {
                    $notify[] = ['error', 'You have no Fixed ROI to withdraw!!'];
                    return redirect()->route('user.home')->withNotify($notify);
                } else {

                    $user->balance += $value->roi * 400;
                    $user->save();
                    $value->roi_last_cron = Carbon::now();
                    $value->roi_last_paid = Carbon::now()->addDays(400);
                    $value->save();
                    $notify[] = ['success', 'Fixed ROI Withdrawn Successfully'];
                }
                return  redirect()->route('user.home')->withNotify($notify);
            } else {

                $notify[] = ['error', 'You can not withdraw the ROI till after 400 days!! '];
                return redirect()->route('user.home')->withNotify($notify);
            }
        }
    }
}
