<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\DigitalAssets;
use App\Models\Epin;
use App\Models\GeneralSetting;
use App\Models\Kyc;
use App\Models\PvLog;
use App\Models\Roi;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\WithdrawMethod;
use App\Models\WithdrawShiba;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index()
    {
        $data['total_ref'] = User::where('ref_id', auth()->id())->count();
        $data['totalWithdraw']   = Withdraw::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $data['totalWithdrawShiba']   = WithdrawShiba::where('user_id', auth()->id())->where('status', 1)->sum('shibainu');
        // $data['roi'] = assignRoi(auth()->id());
        $data['roi'] = User::where('id', auth()->id())->first()->roi;
        // $data['fixed_roi'] = assignFixedRoi(auth()->id());

        $data['weeklyroi'] = Roi::where('user_id', auth()->id())->whereDate('created_at', '>=', Carbon::now()->subDays(9))->where('remark', 'plan_purchased')->sum('roi');

        $data['digital_assets'] = DigitalAssets::where('user_id', auth()->id())->get();
        $data['investments'] = Roi::where('user_id', auth()->id())->where('remark', 'fixed_investment')->get();

        // dd($data);
        $data['empty_message'] = 'No data found';

        return view($this->activeTemplate . 'user.dashboard', $data);
    }
    public function details()
    {
        $data['total_ref'] = User::where('ref_id', auth()->id())->count();
        $data['totalWithdraw']   = Withdraw::where('user_id', auth()->id())->where('status', 1)->sum('amount');
        $data['totalWithdrawShiba']   = WithdrawShiba::where('user_id', auth()->id())->where('status', 1)->sum('shibainu');
        // $data['roi'] = assignRoi(auth()->id());
        $data['roi'] = User::where('id', auth()->id())->first()->roi;
        // $data['fixed_roi'] = assignFixedRoi(auth()->id());

        $data['weeklyroi'] = Roi::where('user_id', auth()->id())->whereDate('created_at', '>=', Carbon::now()->subDays(9))->where('remark', 'plan_purchased')->sum('roi');

        $data['digital_assets'] = DigitalAssets::where('user_id', auth()->id())->get();
        $data['investments'] = Roi::where('user_id', auth()->id())->where('remark', 'fixed_investment')->get();

        // dd($data);
        $data['empty_message'] = 'No data found';

        return view($this->activeTemplate . 'user.details', $data);
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate . 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            // 'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'image' => 'mimes:png,jpg,jpeg',
            'phone' => 'required|string|max:15',
            'pin' => 'required|string|max:15',
            // 'dob' => 'sometimes|required|date',
            // 'gender' => 'sometimes|required',
            // 'martial_status' => 'sometimes|required',

        ], [
            'firstname.required' => 'First Name Field is required',
            'lastname.required' => 'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['crypto_address'] = $request->crypto_address;
        $in['phone'] = $request->phone;
        $in['dob'] = $request->dob;
        $in['gender'] = $request->gender;
        $in['martial_status'] = $request->martial_status;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'country' => $request->country,
        ];
        $in['pin'] = Hash::make($request->pin);
        $user = Auth::user();


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = imagePath()['profile']['user']['size'];
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }
        // dd($in);
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }


    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view($this->activeTemplate . 'user.withdraw.methods', $data);
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your Requested Amount is Smaller Than Minimum Amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your Requested Amount is Larger Than Maximum Amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'Your do not have Sufficient Balance For Withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = getAmount($afterCharge * $method->rate);

        $withdraw = new Withdraw();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = getAmount($request->amount);
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $data['withdraw'] = Withdraw::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        return view($this->activeTemplate . 'user.withdraw.preview', $data);
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdraw::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);
        $user = auth()->user();

        if (getAmount($withdraw->amount) > $user->balance) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['withdraw']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance -= $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = getAmount($withdraw->amount);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = getAmount($withdraw->charge);
        $transaction->trx_type = '-';
        $transaction->details = getAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = route('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw Request Successfully Send'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawShiba(Request $request)
    {
        $general = GeneralSetting::first();
        // $withdraw = WithdrawShiba::with('user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest();

        $rules = [];
        $inputField = [];

        $this->validate($request, $rules);
        $user = auth()->user();
        // decrypt pin
        $pin = Hash::check($request->pin, $user->pin);

        if (!$pin) {
            $notify[] = ['error', 'Invalid Pin'];
            return back()->withNotify($notify);
        }

        if (getAmount($user->shibainu) == 0 && $request->shibainu > getAmount($user->shibainu)) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        }
        $withdraw = new WithdrawShiba();
        $withdraw->user_id = $user->id;
        $withdraw->shibainu = $request->shibainu;
        $withdraw->trx = getTrx();
        $withdraw->final_shibainu = $user->shibainu - $request->shibainu;
        $withdraw->status = 2;
        $withdraw->save();

        $user->shibainu -= $withdraw->shibainu;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = getAmount($withdraw->shibainu);
        $transaction->post_balance = getAmount($user->shibainu);
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = getAmount($withdraw->final_amount) . ' ' . "SHIB" . ' Withdraw Via ' . "Shiba";
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = route('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => "Shiba",
            'method_currency' => "SHIB",
            'method_amount' => getAmount($withdraw->final_shibainu),
            'amount' => getAmount($withdraw->shibainu),
            'charge' => 0,
            'currency' => $general->cur_text,
            'rate' => 0,
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->shibainu),
            'delay' => 0
        ]);

        $notify[] = ['success', 'Withdraw Request Successfully Send'];
        return back()->withNotify($notify);
    }

    public function withdrawLog(Request $request)
    {
        $data['page_title'] = "Withdraw Log";
        // if ($request->type) {
        //     if ($request->type == 'withdrawShiba') {
        //         $data['withdraws'] = WithdrawShiba::with('user')->where('user_id', auth()->user()->id)->latest()->paginate(20);
        //     } else {
        $data['withdraws'] = Withdraw::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->latest()->paginate(getPaginate());
        //     }
        // } 
        $data['empty_message'] = 'No data found';
        return view($this->activeTemplate . 'user.withdraw.log', $data);
    }

    function indexTransfer()
    {
        $page_title = 'Balance Transfer';
        return view($this->activeTemplate . 'user.balanceTransfer', compact('page_title'));
    }

    function balanceTransfer(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);
        $gnl = GeneralSetting::first();
        $user = User::find(Auth::id());
        $trans_user = User::where('username', $request->username)->first();



        if ($trans_user == '') {
            $notify[] = ['error', 'Username Not Found'];
            return back()->withNotify($notify);
        }
        if ($trans_user->username == $user->username) {
            $notify[] = ['error', 'Balance Transfer Not Possible In Your Own Account'];
            return back()->withNotify($notify);
        }
        // $charge = $gnl->bal_trans_fixed_charge + (($request->amount * $gnl->bal_trans_per_charge) / 100);
        $charge = 0;
        $amount = $request->amount + $charge;
        // $amount = $request->amount + $charge;
        if ($user->balance >= $amount) {
            $user->balance -= $amount;
            $user->save();

            $trx = getTrx();

            Transaction::create([
                'trx' => $trx,
                'user_id' => $user->id,
                'trx_type' => '-',
                'remark' => 'balance_transfer',
                'details' => 'Balance Transferred To ' . $trans_user->username,
                'amount' => getAmount($request->amount),
                'post_balance' => getAmount($user->balance),
                'charge' => $charge
            ]);

            notify($user, 'BAL_SEND', [
                'amount' => getAmount($request->amount),
                'username' => $trans_user->username,
                'trx' => $trx,
                'currency' => $gnl->cur_text,
                'charge' => getAmount($charge),
                'balance_now' => getAmount($user->balance),
            ]);

            $trans_user->balance += $request->amount;
            $trans_user->save();

            Transaction::create([
                'trx' => $trx,
                'user_id' => $trans_user->id,
                'remark' => 'balance_receive',
                'details' => 'Balance receive From ' . $user->username,
                'amount' => getAmount($request->amount),
                'post_balance' => getAmount($trans_user->balance),
                'charge' => 0,
                'trx_type' => '+'
            ]);

            notify($trans_user, 'BAL_RECEIVE', [
                'amount' => getAmount($request->amount),
                'currency' => $gnl->cur_text,
                'trx' => $trx,
                'username' => $user->username,
                'charge' => 0,
                'balance_now' => getAmount($trans_user->balance),
            ]);

            $notify[] = ['success', 'Balance Transferred Successfully.'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Insufficient Balance.'];
            return back()->withNotify($notify);
        }
    }


    function searchUser(Request $request)
    {
        $trans_user = User::where('username', $request->username)->count();
        if ($trans_user == 1) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // check pin
    function checkPin(Request $request)
    {
        $user = User::find(Auth::id());
        // decrypt pin
        $pin = Hash::check($request->pin, $user->pin);
        if ($pin) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // show auth user epins created for them
    public function epins()
    {
        $data['page_title'] = "E-Pin Details";
        $data['epins'] = Epin::where('user_id', Auth::id())->where('status', '=', 0)->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate . 'user.epins', $data);
    }

    // show auth user epins created for them
    public function epinsHistory()
    {
        $data['page_title'] = "E-Pin History";
        $data['epins'] = Epin::where('user_id', Auth::id())->where('status', '!=', 0)->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate . 'user.epinsHistory', $data);
    }

    // show auth user unused epins
    public function epinsUnused()
    {
        $data['page_title'] = "Unused E-Pin";
        $data['epins'] = Epin::unused()->where('user_id', Auth::id())->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate . 'user.epins', $data);
    }

    public function claim(Request $request)
    {
        // check if digitial id is valid
        $digital_id = DigitalAssets::where('id', $request->digital_id)->first();
        if ($digital_id == '') {
            $notify[] = ['error', 'Not Available'];
            return back()->withNotify($notify);
        }
        // check if digital id is claimed
        $claimed = DigitalAssets::where('total_claim', $digital_id->plan->claim)->first();
        if ($claimed != '') {
            $notify[] = ['error', 'Already Claimed'];
            return back()->withNotify($notify);
        }

        $digital_id->total_claim++;
        $digital_id->save();

        $notify[] = ['success', 'Digital Asset Claimed Successfully'];
        return back()->withNotify($notify);
    }
}
