<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Epin;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserExtra;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->activeTemplate = activeTemplate();
        // $this->middleware('regStatus')->except('registrationNotAllowed');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegistrationForm(Request $request)
    {
        $content = Frontend::where('data_keys', 'sign_up.content')->first();
        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code = @implode(',', $info['code']);

        if ($request->ref && $request->placer && $request->position) {
            $ref_user = User::where('user_id', $request->ref)->first();
            $ref_placer = User::where('user_id', $request->placer)->first();

            if ($ref_user == null) {
                $notify[] = ['error', 'Invalid Referral link.'];
                return redirect()->route('user.register')->withNotify($notify);
            }
            if ($ref_placer == null) {
                $notify[] = ['error', 'Invalid Referral Placer Link.'];
                return redirect()->route('user.register')->withNotify($notify);
            }

            if ($request->position == 'left') {
                $position = 1;
            } elseif ($request->position == 'right') {
                $position = 2;
            } else {
                $notify[] = ['error', 'Invalid referral position'];
                return redirect()->route('user.register')->withNotify($notify);
            }


            $pos = getPosition($ref_placer->id, $request->position);

            $join_under = User::find($pos['pos_id']);

            // dd($pos, $ref_user->id);

            if ($pos['position'] == "left") {
                if ($join_under->left_side != 0) {
                    $notify[] = ['error', 'This user already have a left position.'];
                    return redirect()->route('user.register')->withNotify($notify);
                }
            } else {
                if ($join_under->right_side != 0) {
                    $notify[] = ['error', 'This user already have a right position.'];
                    return redirect()->route('user.register')->withNotify($notify);
                }
            }

           
            $getPos = $pos['position'];
            if ($getPos == "left"){
                $getPosition = "Left";
            }
            elseif ($getPos == "right"){
                $getPosition = "Right";
            }


            $sponsorss_id = "<span class='help-block'><strong class='text-success'>$ref_user->fullname</strong></span>";
            $placerss_id = "<span class='help-block'><strong class='text-success'>$ref_placer->username</strong></span>";

            $joining = "<span class='text-success'>You are joining under  $join_under->username at $getPosition  position. </span>";

            return view($this->activeTemplate . 'user.auth.register', compact('joining', 'sponsorss_id', 'placerss_id', 'ref_user', 'ref_placer', 'pos', 'position', 'country_code', 'content'));
        }



        $ref_user = null;
        $ref_placer = null;
        $joining = null;


        return view($this->activeTemplate . 'user.auth.register', compact('ref_user', 'ref_placer', 'joining', 'country_code', 'content'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sponsor_id'      => 'required|string|max:160',
            'placer_id'      => 'required|string|max:160',
            'position'      => 'required|integer',
            'firstname'     => 'sometimes|required|string|max:60',
            'lastname'      => 'sometimes|required|string|max:60',
            'email'         => 'required|string|email|max:160',
            'phone'        => 'required|string|max:30|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'username'      => 'required|alpha_num|unique:users|min:6',
            'country'  => 'required'
        ]);
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();


        $exist = User::where('phone', $request->full_phone)->first();
        if ($exist) {
            $notify[] = ['error', 'Mobile number already exist'];
            return back()->withNotify($notify)->withInput();
        }

        $userCheck = User::where('user_id', $request->sponsor_id)->first();
        // dd($request->all());
        if (!$userCheck) {
            $notify[] = ['error', 'Referral Sponsor not found.'];
            return back()->withNotify($notify);
        }

        $placerCheck = User::where('user_id', $request->placer_id)->first();

        if (!$placerCheck) {
            $notify[] = ['error', 'Referral Placer not found.'];
            return back()->withNotify($notify);
        }


        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

        $general = GeneralSetting::first();

        $userCheck = User::where('user_id', $data['sponsor_id'])->first();
        $placerCheck = User::where('user_id',
            $data['placer_id']
        )->first();
        $pos = getPosition($placerCheck->id,
            $data['position']
        );

        // generate strings with random characters and numbers

        // sign up fee $150
        $signup_fee = $general->signup_bonus;
        $assigned_shiba = $general->shiba_bonus;

        //User Create
        $user = new User();
        $user->ref_id           = $userCheck->id;
        $user->pos_id           = $placerCheck->id;
        $user->user_id          = generateRandomInteger(10);
        $user->position         = $pos['position'];
        $user->firstname        = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname         = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email            = strtolower(trim($data['email']));
        $user->password         = Hash::make($data['password']);
        $user->username         = trim($data['username']);
        $user->phone            = $data['full_phone'];
        $user->balance          = 0;
        $user->subscribed_amount = $signup_fee;
        $user->total_ref_com    = 0;
        $user->total_binary_com = 0;
        $user->total_invest     = 0;
        $user->shibainu         = $assigned_shiba;
        $user->epin             = $data['epin'];
        $user->kyc_status      = 0;
        $user->status = 1;
        $user->address      = [
            'address' => '',
            'state' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
        ];
        $user->ev = 1;
        $user->sv = 1;
        $user->ts = 0;
        $user->tv = 1;
        $user->save();

    
        $posId = $user->user_id;
        $placerId = $placerCheck->user_id;

        // update the placer id

        //  check if left or right side is full
        if ($pos['position'] == 1) {
            User::where('user_id', $placerId)->update(['left_side' => $posId]);
        }
        if ($pos['position'] == 2) {
            User::where('user_id', $placerId)->update(['right_side' => $posId]);
        }

        // Check Epins
        $epin = Epin::where('epin', $data['epin'])->first();
        if ($epin) {
            $epin->status = 1;
            $epin->save();
        }

        // calculate the binary commission
        $binaryCommision = $signup_fee;

        // calculate the referral commission
        $referralCommision = $signup_fee * 0.1334;
        $refShibaCom = $assigned_shiba * 0.25;

        $shiba = $assigned_shiba * 0.05;
        
        $username = $data['username'];

        // commission bonus for sponsor 
        $sponsor = User::find($userCheck->id);
      

        // dd($sponsor);
        if ($sponsor) {
            $detailRefCom = "You have received a commission bonus of $referralCommision from $username";
            $detailRefShibaCom = "You have received a commission bonus of $refShibaCom  shiba from $username";
            $detailBinaryShibaCom = "You have received a commission bonus of $shiba shiba";
            $detailPV = "You have received $binaryCommision PV from $username";

            $amount = $referralCommision;
            $sponsor->total_ref_com += $amount;
            $sponsor->balance += $amount;
            $sponsor->total_ref_shiba += $refShibaCom;


            $sponsor->save();

            $pv = $signup_fee;

            // $shiba = $shibaUpline;


            updateRegPV($user->id, $pv, $detailPV);
            // updateRegShiba($user->id, $shiba, $detailRefShibaCom);

            // check for matching bonus
            matchingBonus($sponsor->id, $pv, $user->id);

            // matching bonus for sponsor in shiba
            matchingBonusShiba($sponsor->id, $shiba);

            shibaBinaryComission($user->id, $shiba, $detailBinaryShibaCom);

            $sponsor->transactions()->create([
                'amount' => $referralCommision,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $detailRefCom,
                'remark' => 'referral_commission',
                'trx' => getTrx(),
                'post_balance' => getAmount($sponsor->balance),
            ]);
            $sponsor->transactions()->create([
                'amount' => $refShibaCom,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $detailRefShibaCom,
                'remark' => 'referral_commission',
                'trx' => getTrx(),
                'post_balance' => getAmount($sponsor->shibainu),
            ]);

        }

        return $user;
    }
    public function registered(Request $request, $user)
    {
        $user_extras = new UserExtra();
        $user_extras->user_id = $user->id;
        $user_extras->save();
        updatePaidCount($user->id);
        return redirect()->route('user.home');
    }
}
