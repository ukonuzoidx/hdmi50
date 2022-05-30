<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PvLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function pvLog(Request $request)
    {

        if ($request->type) {
            if ($request->type == 'leftPV') {
                $data['page_title'] = "Left PV";
                $data['logs'] = PvLog::where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } elseif ($request->type == 'rightPV') {
                $data['page_title'] = "Right PV";
                $data['logs'] = PvLog::where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } elseif ($request->type == 'cutPV') {
                $data['page_title'] = "Cut PV";
                $data['logs'] = PvLog::where('trx_type', '-')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } else {
                $data['page_title'] = "All Paid PV";
                $data['logs'] = PvLog::where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            }
        } else {
            $data['page_title'] = "PV LOG";
            $data['logs'] = PvLog::orderBy('id', 'desc')->paginate(config('constants.table.default'));
        }
        // dd($data);

        $data['empty_message'] = 'No data found';
        return view('admin.reports.pvLog', $data);
    }

    public function singlePvLog(Request $request, $id)
    {

        $user = User::findOrFail($id);
        if ($request->type) {
            if ($request->type == 'leftPV') {
                $data['page_title'] = $user->username . " - Left PV";
                $data['logs'] = PvLog::where('user_id', $user->id)->where('position', 1)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } elseif ($request->type == 'rightPV') {
                $data['page_title'] = $user->username . " - Right PV";
                $data['logs'] = PvLog::where('user_id', $user->id)->where('position', 2)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } elseif ($request->type == 'cutPV') {
                $data['page_title'] = $user->username . " - All Cut PV";
                $data['logs'] = PvLog::where('user_id', $user->id)->where('trx_type', '-')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            } else {
                $data['page_title'] = $user->username . " - All Paid PV";
                $data['logs'] = PvLog::where('user_id', $user->id)->where('trx_type', '+')->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
            }
        } else {
            $data['page_title'] = $user->username . " - All  PV";
            $data['logs'] = PvLog::where('user_id', $user->id)->orderBy('id', 'desc')->with('user')->paginate(config('constants.table.default'));
        }

        $data['empty_message'] = 'No data found';
        return view('admin.reports.pvLog', $data);
    }



    public function refCom(Request $request)
    {
        if ($request->userID) {
            $user = User::findOrFail($request->userID);
            $page_title = $user->username . ' - Referral Commission Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'referral_commission')->with('user')->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Referral Commission Logs';
            $transactions = Transaction::where('remark', 'referral_commission')->with('user')->latest()->paginate(getPaginate());
        }

        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function binary(Request $request)
    {
        if ($request->userID) {
            $user = User::findOrFail($request->userID);
            $page_title = $user->username . ' - Binary Commission Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'binary_commission')->with('user')->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Referral Commission Logs';
            $transactions = Transaction::where('remark', 'binary_commission')->with('user')->latest()->paginate(getPaginate());
        }

        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }
    public function invest(Request $request)
    {
        if ($request->userID) {
            $user = User::findOrFail($request->userID);
            $page_title = $user->username . ' - Invest Logs';
            $transactions = Transaction::where('user_id', $user->id)->where('remark', 'purchased_plan')->with('user')->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Invest Logs';
            $transactions = Transaction::where('remark', 'purchased_plan')->with('user')->latest()->paginate(getPaginate());
        }

        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }
    public function transaction()
    {
        $page_title = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Transactions Search - ' . $search;
        $empty_message = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    // public function loginHistory(Request $request)
    // {
    //     if ($request->search) {
    //         $search = $request->search;
    //         $page_title = 'User Login History Search - ' . $search;
    //         $empty_message = 'No search result found.';
    //         $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
    //             $query->where('username', $search);
    //         })->orderBy('id', 'desc')->paginate(getPaginate());
    //         return view('admin.reports.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
    //     }
    //     $page_title = 'User Login History';
    //     $empty_message = 'No users login found.';
    //     $login_logs = UserLogin::orderBy('id', 'desc')->paginate(getPaginate());
    //     return view('admin.reports.logins', compact('page_title', 'empty_message', 'login_logs'));
    // }

    // public function loginIpHistory($ip)
    // {
    //     $page_title = 'Login By - ' . $ip;
    //     $login_logs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->paginate(getPaginate());
    //     $empty_message = 'No users login found.';
    //     return view('admin.reports.logins', compact('page_title', 'empty_message', 'login_logs'));
    // }
}
