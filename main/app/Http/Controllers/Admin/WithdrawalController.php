<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\WithdrawMethod;
use App\Models\WithdrawShiba;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Withdrawals';
        $withdrawals = Withdraw::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        $type = 'pending';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }
    public function approved()
    {
        $page_title = 'Approved Withdrawals';
        $withdrawals = Withdraw::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        $type = 'approved';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Withdrawals';
        $withdrawals = Withdraw::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        $type = 'rejected';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function log()
    {
        $page_title = 'Withdrawals Log';
        $withdrawals = Withdraw::where('status', '!=', 0)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }
    public function shibaPending()
    {
        $page_title = 'Pending Shiba Withdrawals';
        $withdrawals = WithdrawShiba::where('status', 2)->with(['user'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        $type = 'pending';
        return view('admin.withdraw.withdrawalShiba', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }
    public function shibaApproved()
    {
        $page_title = 'Approved Shiba Withdrawals';
        $withdrawals = WithdrawShiba::where('status', 1)->with(['user'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        $type = 'approved';
        return view('admin.withdraw.withdrawalShiba', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function shibaRejected()
    {
        $page_title = 'Rejected Shiba Withdrawals';
        $withdrawals = WithdrawShiba::where('status', 3)->with(['user'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        $type = 'rejected';
        return view('admin.withdraw.withdrawalShiba', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function shibaLog()
    {
        $page_title = 'Shiba Withdrawals Log';
        $withdrawals = WithdrawShiba::where('status', '!=', 0)->with(['user'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawalShiba', compact('page_title', 'withdrawals', 'empty_message'));
    }


    public function logViaMethod($method_id, $type = null)
    {
        $method = WithdrawMethod::findOrFail($method_id);
        if ($type == 'approved') {
            $page_title = 'Approved Withdraw Via ' . $method->name;
            $withdrawals = Withdraw::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Withdrawals Via ' . $method->name;
            $withdrawals = Withdraw::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'pending') {
            $page_title = 'Pending Withdrawals Via ' . $method->name;
            $withdrawals = Withdraw::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Withdrawals Via ' . $method->name;
            $withdrawals = Withdraw::where('status', '!=', 0)->with(['user', 'method'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'method'));
    }


    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdraw::with(['user', 'method'])->where('status', '!=', 0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
        });

        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Withdraw Search';
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Withdraw Search';
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Withdraw Search';
                $withdrawals = $withdrawals->where('status', 3);
                break;
            case 'log':
                $page_title .= 'Withdraw History Search';
                break;
        }

        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'search', 'scope', 'withdrawals'));
    }

    public function dateSearch(Request $request, $scope)
    {
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-', $search);

        if (!(@strtotime($date[0]) && @strtotime($date[1]))) {
            $notify[] = ['error', 'Please provide valid date'];
            return back()->withNotify($notify);
        }

        $start = @$date[0];
        $end = @$date[1];
        if ($start) {
            $withdrawals = Withdraw::where('status', '!=', 0)->where('created_at', '>', Carbon::parse($start)->subDays(1))->where('created_at', '<=', Carbon::parse($start)->addDays(1));
        }
        if ($end) {
            $withdrawals = Withdraw::where('status', '!=', 0)->where('created_at', '>', Carbon::parse($start)->subDays(1))->where('created_at', '<', Carbon::parse($end));
        }
        if ($request->method) {
            $method = WithdrawMethod::findOrFail($request->method);
            $withdrawals = $withdrawals->where('method_id', $method->id);
        }

        switch ($scope) {
            case 'pending':
                $withdrawals = $withdrawals->where('status', 2);
                break;
            case 'approved':
                $withdrawals = $withdrawals->where('status', 1);
                break;
            case 'rejected':
                $withdrawals = $withdrawals->where('status', 3);
                break;
        }

        $withdrawals = $withdrawals->with(['user', 'method'])->paginate(getPaginate());
        $page_title = 'Withdraw Log';
        $empty_message = 'No Withdrawals Found';
        $dateSearch = $search;
        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'dateSearch', 'withdrawals', 'scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdraw::where('id', $id)->where('status', '!=', 0)->with(['user', 'method'])->firstOrFail();
        $page_title = $withdrawal->user->username . ' Withdraw Requested ' . getAmount($withdrawal->amount) . ' ' . $general->cur_text;
        $details = ($withdrawal->withdraw_information != null) ? json_encode($withdrawal->withdraw_information) : null;


        $methodImage =  getImage(imagePath()['withdraw']['method']['path'] . '/' . $withdrawal->method->image, '800x800');

        return view('admin.withdraw.detail', compact('page_title', 'withdrawal', 'details', 'methodImage'));
    }
    public function shibaDetails($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = WithdrawShiba::where('id', $id)->where('status', '!=', 0)->with(['user'])->firstOrFail();
        $page_title = $withdrawal->user->username . ' Withdraw Requested ' . getAmount($withdrawal->shibainu) . ' ' . 'SHIB';
        $details = ($withdrawal->withdraw_information != null) ? json_encode($withdrawal->withdraw_information) : null;


        return view('admin.withdraw.detailShiba', compact('page_title', 'withdrawal', 'details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdraw::where('id', $request->id)->where('status', 2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdraw Marked  as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdraw::where('id', $request->id)->where('status', 2)->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->balance += getAmount($withdraw->amount);
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->amount) . ' ' . "USD" . ' Refunded from Withdraw Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdraw has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

    public function shibaApprove(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = WithdrawShiba::where('id', $request->id)->where('status', 2)->with('user')->firstOrFail();
        $withdraw->admin_feedback = $request->details;
        $withdraw->status = 1;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => "Shiba Withdraw",
            'method_currency' => "SHIB",
            'amount' => getAmount($withdraw->shibainu),
            'currency' => "SHIB",
            'trx' => $withdraw->trx,
        ]);

        $notify[] = ['success', 'Withdraw Shiba as Approved.'];
        return redirect()->route('admin.withdraw.shiba.pending')->withNotify($notify);
    }


    public function shibaReject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = WithdrawShiba::where('id', $request->id)->where('status', 2)->firstOrFail();
        $withdraw->admin_feedback = $request->details;
        $withdraw->status = 3;  
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->shibainu += getAmount($withdraw->shibainu);
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->shibainu;
        $transaction->post_balance = getAmount($user->shibainu);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->shibainu) . ' ' . "SHIB" . ' Refunded from Withdraw Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => "SHIBA Withdraw",
            'method_currency' => "SHIBA",
            'amount' => getAmount($withdraw->shibainu),
            'charge' => getAmount($withdraw->charge),
            'currency' => "SHIB",
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->shibainu),
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Shiba Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.shiba.pending')->withNotify($notify);
    }
}
