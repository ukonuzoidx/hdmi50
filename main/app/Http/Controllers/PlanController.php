<?php

namespace App\Http\Controllers;

use App\Models\DigitalAssets;
use App\Models\Epin;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\PvLog;
use App\Models\Roi;
use App\Models\SubscribedPlans;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
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

    function planStore(Request $request)
    {
        $this->validate($request, ['plan_id' => 'required|integer']);
        $plan = Plan::where('id', $request->plan_id)->where('status', 1)->firstOrFail();
        $gnl = GeneralSetting::first();

        $user = User::find(Auth::id());
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


        // $oldPlan = $user->plan_id;
        $user->balance -= $plan->price;
        $user->total_invest += $plan->price;
        $user->roi += $plan->roi;
        $user->balance += $plan->roi;
        $user->save();


        $roi = Roi::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'roi' => $plan->roi,
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
        // $assigned_shiba = $gnl->shiba_bonus;

        // $shiba = $assigned_shiba * 0.05;
        $shiba = $gnl->shiba_bonus * 0.05;

        $details = Auth::user()->username . ' Subscribed to ' . $plan->name . ' plan.';
        $detailBinaryShibaCom = "You have received a commission bonus of $shiba shiba";


        updatePV($user->id, $plan->pv, $details);

        if ($plan->tree_com > 0) {
            // dd($plan->tree_com);

            treeCommission($user->id, $plan->tree_com, $details);
            // shibaBinaryComission($user->id, $shiba, $detailBinaryShibaCom);
        }
        referralCommission($user->id, $details, $plan->id);

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
