<?php

namespace App\Http\Controllers;

use App\Models\Epin;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\PvLog;
use App\Models\SubscribedPlans;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view("user.pvlog", $data);
    }

    function planStore(Request $request)
    {
        $this->validate($request, ['plan_id' => 'required|integer']);
        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->firstOrFail();
        $gnl = GeneralSetting::first();

        $user = User::find(Auth::id());
        // check if epin is used and amount in the epin is greater than the amount in the plan
        $epin = Epin::where('epin', $request->epin)->where('status', 0)->first();

        if ($epin) {
            if ($epin->amount > $plan->price) {
                $notify[] = ['error', 'Epin amount is greater than plan amount'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Epin is not valid'];
            return back()->withNotify($notify);
        }
        // dd($epin);

        if ($epin->amount < $plan->price) {
            $notify[] = ['error', 'Epin amount is less than plan amount'];
            return back()->withNotify($notify);
        }

        // $oldPlan = $user->plan_id;
        $user->total_invest += $plan->price;
        $user->save();

        SubscribedPlans::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'subscribed_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+12 months')),
        ]);


        // update epin status
        $epin->status = 1;
        $epin->save();


        $trx = $user->transactions()->create([
            'amount' => $plan->price,
            'trx_type' => '-',
            'details' => 'Purchased ' . $plan->name,
            'remark' => 'purchased_plan',
            'trx' => getTrx(),
            'post_balance' => getAmount($epin->amount),
        ]);

        notify($user, 'plan_purchased', [
            'plan' => $plan->name,
            'amount' => getAmount($plan->price),
            'currency' => $gnl->cur_text,
            'trx' => $trx->trx,
            'post_balance' => getAmount($epin->amount) . ' ' . $gnl->cur_text,
        ]);
        // if ($oldPlan == 0) {
        // updatePaidCount($user->id);
        // }
        $details = Auth::user()->username . ' Subscribed to ' . $plan->name . ' plan.';

        updatePV($user->id, $plan->pv, $details);

        if ($plan->tree_com > 0) {
            treeComission($user->id, $plan->tree_com, $details);
        }

        referralComission($user->id, $details);

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
}
