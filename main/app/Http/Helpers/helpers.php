<?php

use App\Models\EmailTemplate;
use App\Models\Extension;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\MatchingBonus;
use App\Models\Plan;
use App\Models\PvLog;
use App\Models\Roi;
use App\Models\User;
use App\Models\UserExtra;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Magarrent\LaravelUrlShortener\Models\UrlShortener;
use Illuminate\Support\Facades\Mail;
use League\CommonMark\Node\Query\AndExpr;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


// get Ip Info
function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');


    return $data;
}

function getPosition($parentId, $position)
{
    $childId = getTreeChildId($parentId, $position);

    if ($childId != "-1") {
        $id = $childId;
    } else {
        $id = $parentId;
    }
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $nextchildId = getTreeChildId($id, $position);
            if ($nextchildId == "-1") {
                break;
            } else {
                $id = $nextchildId;
            }
        } else break;
    }

    $res['pos_id'] = $id;
    $res['position'] = $position;
    return $res;
}

function getTreeChildId($parentId, $position)
{
    $cou = User::where('pos_id', $parentId)->where('position', $position)->count();
    $cid = User::where('pos_id', $parentId)->where('position', $position)->first();
    if ($cou == 1) {
        return $cid->id;
    } else {
        return -1;
    }
}

function isUserExists($id)
{
    $user = User::find($id);
    if ($user) {
        // dd($user);
        return true;
    } else {
        return false;
    }
}

function mlmPositions()
{
    return [
        '1' => 'Left',
        '2' => 'Right',
    ];
}

function getPositionId($id)
{
    $user = User::find($id);
    if ($user) {
        // dd($user->pos_id);
        return $user->pos_id;
    } else {
        return 0;
    }
}

function getPositionLocation($id)
{
    $user = User::find($id);
    if ($user) {
        return $user->position;
    } else {
        return 0;
    }
}

function updateFreeCount($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);


            $extra = UserExtra::where('user_id', $posid)->first();
            // dd($position, $posid, $extra->free_left);

            if ($position == 1) {
                $extra->free_left += 1;
            } else {
                $extra->free_right += 1;
            }
            $extra->save();

            $id = $posid;
        } else {
            break;
        }
    }
}

function updatePaidCount($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);

            $extra = UserExtra::where('user_id', $posid)->first();

            if ($position == 1) {
                // $extra->free_left -= 1;
                $extra->paid_left += 1;
                // $extra->pre_paid_left += 1;
            } else {
                // $extra->free_right -= 1;
                $extra->paid_right += 1;
                // $extra->pre_paid_right += 1;
            }
            $extra->save();
            $id = $posid;
        } else {
            break;
        }
    }
}


function updateRegPV($id, $pv, $shiba, $details)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);
            $extra = UserExtra::where('user_id', $posid)->first();
            $pvlog = new PvLog();
            $pvlog->user_id = $posid;



            if ($position == 1) {
                $extra->pv_left += $pv;
                $extra->lpv += $pv;
                $extra->shiba_left += $shiba;
                $pvlog->position = '1';
            } else {
                $extra->pv_right += $pv;
                $extra->rpv += $pv;
                $extra->shiba_right += $shiba;
                $pvlog->position = '2';
            }
            $extra->save();
            $pvlog->amount = $pv;
            $pvlog->trx_type = '+';
            $pvlog->details = $details;
            $pvlog->save();


            $id = $posid;
        } else {
            break;
        }
    }
}

// function matchingBonus($id, $pv, $placerId, $refShibaCom)
// {

//     if (isUserExists($id)) {
//         $posid = getPositionId($id);
//         if ($posid == "0") {
//             break;
//         }
//         $position = getPositionLocation($id);
//         $extra = UserExtra::where('user_id', $posid)->first();
//         $pvlog = new PvLog();
//         $pvlog->user_id = $posid;


//     $eligibleUsers = UserExtra::where('bv_left', '>=', )->where('bv_right', '>=', $gnl->total_bv)->get();
//     foreach ($eligibleUsers as $uex) {
//         $user = $uex->user;
//         $weak = $uex->bv_left < $uex->bv_right ? $uex->bv_left : $uex->bv_right;
//         $weaker = $weak < $gnl->max_bv ? $weak : $gnl->max_bv;

//         $pair = intval($weaker / $gnl->total_bv);

//         $bonus = $pair * $gnl->bv_price;
//     }
//     }
// }


function matchingBonus($id, $pv, $refShibaCom)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $user = User::find($posid);
            $extra = UserExtra::where('user_id', $posid)->where('lpv', '>=', '150')->where('rpv', '>=', '150')->first();
            if ($extra) {
                $lpv = $extra->lpv;
                $rpv = $extra->rpv;
                $weak = $lpv < $rpv ? $lpv : $rpv;
                $bonus = 0.1 * $pv;
                //flush out the bonus
                $extra->lpv -= $weak;
                $extra->rpv -= $weak;
                $extra->save();

                $pvlog = new PvLog();
                $pvlog->user_id = $posid;
                $pvlog->amount = $bonus;
                $pvlog->trx_type = '+';
                $pvlog->details = 'Matching Bonus';
                $pvlog->save();
                $user->balance += $bonus;
                $user->total_binary_com += $bonus;
                $user->save();
                $user->shibainu += $refShibaCom;
                $user->total_binary_shiba += "10000";
                $user->save();
                $pvlog = new PvLog();
                $pvlog->user_id = $posid;
                $pvlog->amount = $refShibaCom;
                $pvlog->trx_type = '+';
                $pvlog->details = 'Matching Shiba Bonus';
                $pvlog->save();
                $user->transactions()->create([
                    'amount' => $bonus,
                    'charge' => 0,
                    'trx_type' => '+',
                    'details' => 'Matching Bonus',
                    'remark' => 'binary_commission',
                    'trx' => getTrx(),
                    'post_balance' => getAmount($user->balance),
                ]);
            }


            $id = $posid;
        } else {
            break;
        }
    }
}
// function matchingBonus($id, $pv, $refShibaCom)
// {
//     while ($id != "" || $id != "0") {
//         if (isUserExists($id)) {
//             $posid = getPositionId($id);
//             if ($posid == "0") {
//                 break;
//             }
//             $user = User::find($posid);
//             $extra = UserExtra::where('user_id', $posid)->where('lpv', '>=', '150')->where('rpv', '>=', '150')->first();
//             if ($extra) {

//                 $lpv = $extra->lpv;
//                 $rpv = $extra->rpv;
//                 $weak = $lpv < $rpv ? $lpv : $rpv;
//                 // $bonus = 0.1 * 150;
//                 // //flush out the bonus
//                 // $extra->lpv -= $weak;
//                 // $extra->rpv -= $weak;
//                 // $extra->save();

//                 // $pvlog = new PvLog();
//                 // $pvlog->user_id = $posid;
//                 // $pvlog->amount = $bonus;
//                 // $pvlog->trx_type = '+';
//                 // $pvlog->details = 'Matching Bonus';
//                 // $pvlog->save();
//                 // $user->total_binary_com += $bonus;
//                 // $user->save();
//                 if ($extra->pv_left < $extra->pv_right) {
//                     $user->balance += $extra->pv_left * 0.1;
//                     $user->total_binary_com += $extra->pv_left * 0.1;
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $pv;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Bonus';
//                     $user->shibainu += $refShibaCom;
//                     $user->total_binary_shiba += "10000";
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $refShibaCom;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Shiba Bonus';
//                     $pvlog->save();
//                 } else if ($extra->pv_right < $extra->pv_left) {
//                     $user->balance += $extra->pv_right * 0.1;
//                     $user->total_binary_com += $extra->pv_right * 0.1;
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $pv;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Bonus';
//                     $pvlog->save();
//                     $user->shibainu += $refShibaCom;
//                     $user->total_binary_shiba += "10000";
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $refShibaCom;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Shiba Bonus';
//                     $pvlog->save();
//                 } else if ($extra->pv_left == $extra->pv_right) {
//                     $user->balance += $extra->pv_left * 0.1;
//                     $user->total_binary_com += $extra->pv_left * 0.1;
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $pv;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Bonus';
//                     $pvlog->save();
//                     $user->shibainu += $refShibaCom;
//                     $user->total_binary_shiba += "10000";
//                     $user->save();
//                     $pvlog = new PvLog();
//                     $pvlog->user_id = $posid;
//                     $pvlog->amount = $refShibaCom;
//                     $pvlog->trx_type = '+';
//                     $pvlog->details = 'Matching Shiba Bonus';
//                     $pvlog->save();
//                 }
//             }


//             $id = $posid;
//         } else {
//             break;
//         }
//     }



// }


function updatePV($id, $pv, $details)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($id);
            $extra = UserExtra::where('user_id', $posid)->first();
            $pvlog = new PvLog();
            $pvlog->user_id = $posid;

            if ($position == 1) {
                $extra->pv_left += $pv;
                $extra->mlpv += $pv;
                $pvlog->position = '1';
            } else {
                $extra->pv_right += $pv;
                $extra->mrpv += $pv;
                $pvlog->position = '2';
            }
            $extra->save();
            $pvlog->amount = $pv;
            $pvlog->trx_type = '+';
            $pvlog->details = $details;
            $pvlog->save();

            $id = $posid;
        } else {
            break;
        }
    }
}

// shiba binary commission
function shibaBinaryComission($id, $amount, $details)
{
    $fromUser = User::find($id);

    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }

            $posUser = User::find($posid);
            // if ($posUser->plan_id != 0) {

            $posUser->shibainu  += $amount;
            $posUser->total_binary_shiba += $amount;
            $posUser->save();

            $posUser->transactions()->create([
                'amount' => $amount,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $details,
                'remark' => 'binary_commission',
                'trx' => getTrx(),
                'post_balance' => getAmount($posUser->shibainu),
            ]);
            $id = $posid;
        } else {
            break;
        }
    }
}








// tree and referral commission
function treeCommission($id, $amount, $details)
{
    $fromUser = User::find($id);

    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $posUser = User::find($posid);
            $posUser->balance  += $amount;
            $posUser->total_binary_com += $amount;
            $posUser->save();

            $posUser->transactions()->create([
                'amount' => $amount,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $details,
                'remark' => 'binary_commission',
                'trx' => getTrx(),
                'post_balance' => getAmount($posUser->balance),
            ]);
            $id = $posid;
        } else {
            break;
        }
    }
}

function referralCommission($user_id, $details, $planId)
{

    $user = User::find($user_id);
    $refer = User::find($user->ref_id);
    if ($refer) {
        $plan = Plan::find($planId);
        if ($plan) {
            $amount = $plan->ref_com;
            $refer->balance += $amount;
            $refer->total_ref_com += $amount;
            $refer->save();

            $trx = $refer->transactions()->create([
                'amount' => $amount,
                'charge' => 0,
                'trx_type' => '+',
                'details' => $details,
                'remark' => 'referral_commission',
                'trx' => getTrx(),
                'post_balance' => getAmount($refer->balance),

            ]);

            $gnl = GeneralSetting::first();

            notify($refer, 'referral_commission', [
                'trx' => $trx->trx,
                'amount' => getAmount($amount),
                'currency' => $gnl->cur_text,
                'username' => $user->username,
                'post_balance' => getAmount($refer->balance),
            ]);
        }
    }
}

function matchingPVBonus($id, $pv, $details)
{
    $fromUser = User::find($id);

    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0") {
                break;
            }
            $user = User::find($posid);
            $extra = UserExtra::where('user_id', $posid)->where('mlpv', '>=', '200')->where('mrpv', '>=', '200')->first();
            if ($extra) {
                $lpv = $extra->mlpv;
                $rpv = $extra->mrpv;
                $weak = $lpv < $rpv ? $lpv : $rpv;
                $bonus = 0.1 * $pv;
                //flush out the bonus
                $extra->mlpv -= $weak;
                $extra->mrpv -= $weak;
                $extra->save();

                $pvlog = new PvLog();
                $pvlog->user_id = $posid;
                $pvlog->amount = $bonus;
                $pvlog->trx_type = '+';
                $pvlog->details = "Matching PV Bonus";
                $pvlog->save();
                $user->balance += $bonus;
                $user->total_binary_com += $bonus;
                $user->save();
                $user->transactions()->create([
                    'amount' => $bonus,
                    'charge' => 0,
                    'trx_type' => '+',
                    'trx' => getTrx(),
                    'details' => $details,
                    'remark' => 'binary_commission',
                    'trx' => getTrx(),
                    'post_balance' => getAmount($user->balance),
                ]);
            }


            $id = $posid;
        } else {
            break;
        }
    }
}



// get Amount
function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return round($amount + 0, $length);
    }
    return $amount + 0;
}

function printEmail($email)
{
    $beforeAt = strstr($email, '@', true);
    $withStar = substr($beforeAt, 0, 2) . str_repeat("**", 5) . substr($beforeAt, -2) . strstr($email, '@');
    return $withStar;
}


function showDateTime($date, $format = 'd M, Y h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function getImage($image, $size = null)
{
    $clean = '';
    $size = $size ? $size : 'undefined';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    } else {
        return route('placeholderImage', $size);
    }
}
function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }
    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $image = Image::make($file);
    if (!empty($size)) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1], function ($constraint) {
            $constraint->upsize();
        });
    }
    $image->save($location . '/' . $filename);

    if (!empty($thumb)) {

        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1], function ($constraint) {
            $constraint->upsize();
        })->save($location . '/thumb_' . $filename);
    }

    return $filename;
}

function uploadFile($file, $location, $size = null, $old = null)
{
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $file->move($location, $filename);
    return $filename;
}
function imagePath()
{
    $data['gateway'] = [
        'path' => 'assets/images/gateway',
        'size' => '800x800',
    ];
    $data['verify'] = [
        'withdraw' => [
            'path' => 'assets/images/verify/withdraw'
        ],
        'deposit' => [
            'path' => 'assets/images/verify/deposit'
        ]
    ];
    $data['image'] = [
        'default' => 'assets/images/default.png',
    ];
    $data['withdraw'] = [
        'method' => [
            'path' => 'assets/images/withdraw/method',
            'size' => '800x800',
        ]
    ];
    $data['ticket'] = [
        'path' => 'assets/images/support',
    ];
    $data['language'] = [
        'path' => 'assets/images/lang',
        'size' => '64x64'
    ];
    $data['logoIcon'] = [
        'path' => 'assets/images/logoIcon',
    ];
    $data['favicon'] = [
        'size' => '128x128',
    ];
    $data['extensions'] = [
        'path' => 'assets/images/extensions',
    ];
    $data['seo'] = [
        'path' => 'assets/images/seo',
        'size' => '600x315'
    ];
    $data['profile'] = [
        'user' => [
            'path' => 'assets/images/user/profile',
            'size' => '350x300'
        ],
        'admin' => [
            'path' => 'assets/admin/images/profile',
            'size' => '400x400'
        ]
    ];
    return $data;
}

function createPVLog($user_id, $lr, $amount, $details)
{
    $bvlog = new PvLog();
    $bvlog->user_id = $user_id;
    $bvlog->position = $lr;
    $bvlog->amount = $amount;
    $bvlog->trx_type = '-';
    $bvlog->details = $details;
    $bvlog->save();
}



// TREE CREATIONS

function getPositionUserSide($id, $position)
{
    $user = User::where('user_id', $id)->first();
    if ($position == 0) {
        $pos = "left_side";
    } else {
        $pos = "right_side";
    }
    if ($user) {
        return $user->$pos;
    } else {
        return 0;
    }
}


function getPositionUser($id, $position)
{
    return User::where('pos_id', $id)->where('position', $position)->first();
}

function showTreePage($id)
{
    $res = array_fill_keys(array('b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'), null);
    $res['a'] = User::find($id);

    $res['b'] = getPositionUser($id, 1);
    if ($res['b']) {
        $res['d'] = getPositionUser($res['b']->id, 1);
        $res['e'] = getPositionUser($res['b']->id, 2);
    }
    if ($res['d']) {
        $res['h'] = getPositionUser($res['d']->id, 1);
        $res['i'] = getPositionUser($res['d']->id, 2);
    }
    if ($res['e']) {
        $res['j'] = getPositionUser($res['e']->id, 1);
        $res['k'] = getPositionUser($res['e']->id, 2);
    }
    $res['c'] = getPositionUser($id, 2);
    if ($res['c']) {
        $res['f'] = getPositionUser($res['c']->id, 1);
        $res['g'] = getPositionUser($res['c']->id, 2);
    }
    if ($res['f']) {
        $res['l'] = getPositionUser($res['f']->id, 1);
        $res['m'] = getPositionUser($res['f']->id, 2);
    }
    if ($res['g']) {
        $res['n'] = getPositionUser($res['g']->id, 1);
        $res['o'] = getPositionUser($res['g']->id, 2);
    }

    // dd($res, $id);

    return $res;
}



function getUserById($id)
{
    return User::find($id);
}


function showSingleUserInTree($user)
// function showSingleUserInTree($user_info)
{
    $res = '';
    // $user = User::where('user_id', $user_info)->first();
    // dd($user, $user_info);
    if ($user) {
        $userType = "paid";
        $setShow = "Paid";
        // $planName = $user->plan->name;


        // $img = getImage('assets/images/users/profile/profile-pic.png', '120x120');
        $img = getImage('assets/images/user/profile/' . $user->image, '120x120');
        $refBy = getUserById($user->ref_id)->fullname ?? '';
        if (auth()->guard('admin')->user()) {
            $hisTree = route('admin.users.other.tree', $user->username);
        } else {
            $hisTree = route('user.other.tree', $user->username);
        }
        // $sponsId = getUserById($user->id)->user_id ?? '';
        // $placerId = getUserById($user->id)->user_id ?? '';

        // $reflinkLeft = route('user.register', ['ref' => $sponsId, 'placer' => $placerId, 'position' => 'left']);
        // $reflinkRight = route('user.register', ['ref' => $sponsId, 'placer' => $placerId, 'position' => 'right']);

        // $shortleftUrl = urlShort($reflinkLeft);
        // $shortrightUrl = urlShort($reflinkRight);
        // dd($sponsId, $placerId, $shortleftUrl, $shortrightUrl, $reflinkLeft, $reflinkRight);

        $extraData = " data-name=\"$user->fullname\"";
        $extraData .= " data-treeurl=\"$hisTree\"";
        $extraData .= " data-status=\"$setShow\"";
        // $extraData .= " data-plan=\"$planName\"";
        $extraData .= " data-image=\"$img\"";
        $extraData .= " data-refby=\"$refBy\"";
        // $extraData .= " data-sponsorid=\"$sponsId\"";
        // $extraData .= " data-placerid=\"$placerId\"";
        $extraData .= " data-username=\"$user->username\"";
        $extraData .= " data-lfree=\"" . @$user->userExtra->free_left . "\"";
        $extraData .= " data-rfree=\"" . @$user->userExtra->free_right . "\"";
        $extraData .= " data-lpaid=\"" . @$user->userExtra->paid_left . "\"";
        $extraData .= " data-rpaid=\"" . @$user->userExtra->paid_right . "\"";
        $extraData .= " data-lpv=\"" . getAmount(@$user->userExtra->pv_left) . "\"";
        $extraData .= " data-rpv=\"" . getAmount(@$user->userExtra->pv_right) . "\"";
        // $extraData .= "data-leftRef=\"" . $shortleftUrl . "\"";
        // $extraData .= "data-rightRef=\"" . $shortrightUrl . "\"";

        $res .= "<div class=\"user showDetails\" type=\"button\" $extraData>";
        $res .= "<img src=\"$img\" alt=\"*\"  class=\"$userType\">";
        $res .= "<p class=\"user-name\">$user->username</p>";
        // $res .= "<a href=\"route('user.other.tree.search')\" onclick=\"event.preventDefault(); document.getElementById('search-form').submit();\">Check Downline</a>";
        // $res .= "<form id=\"search-form\" action=\"{{ route('user.other.tree.search') }}\" style=\"display: none;\">
        // @csrf
        // <input type=\"hidden\" name=\"username\" value=\"$user->username\">
        // </form>";
        // $res .= "</div>";
    } else {
        $img = getImage('assets/images/user/profile/profile-pic.png', '120x120');

        $res .= "<div class=\"user\" type=\"button\">";
        $res .= "<img src=\"$img\" alt=\"*\"  class=\"no-user\">";
        $res .= "<p class=\"user-name\">No user</p>";
    }

    $res .= " </div>";
    $res .= " <span class=\"line\"></span>";

    return $res;
}


/*
===============TREE AUTH==============
*/
function treeAuth($whichID, $whoID)
{

    if ($whichID == $whoID) {
        return true;
    }
    $formid = $whichID;
    while ($whichID != "" || $whichID != "0") {
        if (isUserExists($whichID)) {
            $posid = getPositionId($whichID);
            if ($posid == "0") {
                break;
            }
            $position = getPositionLocation($whichID);
            // dd($whichID, $whoID, $posid, $formid);
            if ($posid == $whoID) {
                return true;
            }
            $whichID = $posid;
        } else {
            break;
        }
    }
    return 0;
}
// function treeAuth($whichID, $whoID)
// {

//     if ($whichID == $whoID) {
//         return true;
//     }
//     $formid = $whichID;
//     while ($whichID != "" || $whichID != "0") {
//         if (isUserExists($whichID)) {
//             $posid = getPositionId($whichID);
//             if ($posid == "0") {
//                 break;
//             }
//             $position = getPositionLocation($whichID);
//             dd($whichID, $whoID, $posid, $formid);
//             if ($posid == $whoID) {
//                 return true;
//             }
//             $whichID = $posid;
//         } else {
//             break;
//         }
//     }
//     return 0;
// }

function urlShort($url)
{
    $shortUrl = UrlShortener::generateShortUrl($url);
    return $shortUrl;
}

// get trx
function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getPaginate($paginate = 20)
{
    return $paginate;
}
function paginateLinks($data, $design = 'admin.partials.paginate')
{
    return $data->appends(request()->all())->links($design);
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function inputTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}

function sendGeneralEmail($email, $subject, $message, $receiver_name = '')
{

    $general = GeneralSetting::first();

    if ($general->en != 1 || !$general->email_from) {
        return;
    }

    $message = shortCodeReplacer("{{message}}", $message, $general->email_template);
    $message = shortCodeReplacer("{{name}}", $receiver_name, $message);
    $config  = $general->mail_config;

    if ($config->name == 'php') {
        sendPhpMail($email, $receiver_name, $general->email_from, $subject, $message);
    } else if ($config->name == 'smtp') {
        // sendSmtpMail($config, $email, $receiver_name, $general->email_from, $general->sitename, $subject, $message);
        sendSmtpMail($config, $email, $receiver_name, $subject, $message, $general);
    }
}

// notify
/*SMS EMIL moveable*/



function sendEmail($user, $type = null, $shortCodes = [])
{
    $general = GeneralSetting::first();

    $email_template = EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    if ($general->en != 1 || !$email_template) {
        return;
    }

    $message = shortCodeReplacer("{{name}}", $user->username, $general->email_template);
    $message = shortCodeReplacer("{{message}}", $email_template->email_body, $message);

    if (empty($message)) {
        $message = $email_template->email_body;
    }

    foreach ($shortCodes as $code => $value) {
        $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    }
    $config = $general->mail_config;

    // dd($config, $user->email, $user->username, $general->email_from, $email_template->subj, $message);

    if ($config->name == 'php') {
        sendPhpMail($user->email, $user->username, $email_template->subj, $message);
    } else if ($config->name == 'smtp') {
        sendSmtpMail($config, $user->email, $user->username, $email_template->subj, $message, $general);
    }
}


function sendPhpMail($receiver_email, $receiver_name, $subject, $message)
{
    $gnl = GeneralSetting::first();
    $headers = "From: $gnl->sitename <$gnl->email_from> \r\n";
    $headers .= "Reply-To: $gnl->sitename <$gnl->email_from> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail($receiver_email, $subject, $message, $headers);
}


function sendSmtpMail($config, $receiver_email, $receiver_name, $subject, $message, $gnl)
{
    $mail = new PHPMailer(true);
    // dd($config);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->encryption == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($gnl->email_from, $gnl->sitetitle);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($gnl->email_from, $gnl->sitename);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}




function notify($user, $type, $shortCodes = [])
{
    sendEmail($user, $type, $shortCodes);
    // dd($user, $type, $shortCodes);
    // sendSms($user, $type, $shortCodes);
}

function activeTemplate($asset = false)
{
    $gs = GeneralSetting::first(['active_template']);
    $template = $gs->active_template;
    $sess = session()->get('template');
    if (trim($sess) != null) {
        $template = $sess;
    }
    if ($asset) return 'assets/templates/' . $template . '/';
    // dd($asset);
    return 'templates.' . $template . '.';
}

function activeTemplateName()
{
    $gs = GeneralSetting::first(['active_template']);
    $template = $gs->active_template;
    $sess = session()->get('template');
    if (trim($sess) != null) {
        $template = $sess;
    }
    return $template;
}

function getContent($data_keys, $singleQuery = false, $limit = null, $orderById = false)
{
    if ($singleQuery) {
        $content = Frontend::where('data_keys', $data_keys)->latest()->first();
    } else {
        $article = Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if ($orderById) {
            $content = $article->where('data_keys', $data_keys)->orderBy('id')->get();
        } else {
            $content = $article->where('data_keys', $data_keys)->latest()->get();
        }
    }
    return $content;
}

function getPageSections($arr = false)
{

    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}
function curlPostContent($url, $arr = null)
{
    if ($arr) {
        $params = http_build_query($arr);
    } else {
        $params = '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function systemDetails()
{
    $system['name'] = 'bisurv';
    $system['version'] = '1.0';
    return $system;
}



function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.viserlab.com/updates/templates/' . systemDetails()['name'];
    $result = curlPostContent($url, $param);
    if ($result) {
        return $result;
    } else {
        return null;
    }
}
function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function menuActive($routeName, $type = null)
{
    if ($type == 3) {
        $class = 'side-menu--open';
    } elseif ($type == 2) {
        $class = 'sidebar-submenu__open';
    } else {
        $class = 'active';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}

function reCaptcha()
{
    $reCaptcha = Extension::where('act', 'google-recaptcha2')->where('status', 1)->first();
    return $reCaptcha ? $reCaptcha->generateScript() : '';
}

function analytics()
{
    $analytics = Extension::where('act', 'google-analytics')->where('status', 1)->first();
    return $analytics ? $analytics->generateScript() : '';
}

function tawkto()
{
    $tawkto = Extension::where('act', 'tawk-chat')->where('status', 1)->first();
    return $tawkto ? $tawkto->generateScript() : '';
}

function fbcomment()
{
    $comment = Extension::where('act', 'fb-comment')->where('status', 1)->first();
    return  $comment ? $comment->generateScript() : '';
}

function getCustomCaptcha($height = 46, $width = '300px', $bgcolor = '#003', $textcolor = '#abc')
{
    $textcolor = '#' . GeneralSetting::first()->base_color;
    $captcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();
    if ($captcha) {
        $code = rand(100000, 999999);
        $char = str_split($code);
        $ret = '<link href="https://fonts.googleapis.com/css?family=Henny+Penny&display=swap" rel="stylesheet">';
        $ret .= '<div style="height: ' . $height . 'px; line-height: ' . $height . 'px; width:' . $width . '; text-align: center; background-color: ' . $bgcolor . '; color: ' . $textcolor . '; font-size: ' . ($height - 20) . 'px; font-weight: bold; letter-spacing: 20px; font-family: \'Henny Penny\', cursive;  -webkit-user-select: none; -moz-user-select: none;-ms-user-select: none;user-select: none;  display: flex; justify-content: center;">';
        foreach ($char as $value) {
            $ret .= '<span style="    float:left;     -webkit-transform: rotate(' . rand(-60, 60) . 'deg);">' . $value . '</span>';
        }
        $ret .= '</div>';
        $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
        $ret .= '<input type="hidden" name="captcha_secret" value="' . $captchaSecret . '">';
        return $ret;
    } else {
        return false;
    }
}


function captchaVerify($code, $secret)
{
    $captcha = Extension::where('act', 'custom-captcha')->where('status', 1)->first();
    $captchaSecret = hash_hmac('sha256', $code, $captcha->shortcode->random_key->value);
    if ($captchaSecret == $secret) {
        return true;
    }
    return false;
}


function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}


// generate random string
function generateRandomString($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// generate random integer
function generateRandomInteger($length)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


/**
 * Go through the general settings and see how long a roi is to be updated
 * add roi to the user if the time is up
 * @return bool
 * 
 */
function seeWeeklyRoiEarned($id)
{
    // check if the user has a roi
    $user = User::find($id);
    $gnl = GeneralSetting::first();
    $roi = Roi::where('user_id', $user->id)->first();

    $dateFrom = Carbon::now()->subDays(7);
    $dateTo = Carbon::now();
    $weekly = Roi::where('user_id', $user->id)->whereBetween('roi_last_paid', [$dateFrom, $dateTo])->count();
    $previousDateFrom = Carbon::now()->subDays(14);
    $previousDateTo = Carbon::now()->subDays(8);
    $previousWeekly = Roi::where('user_id', $user->id)->whereBetween('created_at', [$previousDateFrom, $previousDateTo])->count();


    /**
     * If the user has a weekly roi then check if the user has a previous weekly roi
     * then sum the total for that week
     * if the user has no previous weekly roi then sum the total for that week
     * 
     */
    if ($user && $roi) {

        if ($weekly > 0) {
            if ($previousWeekly > 0) {
                $weeklyRoi = Roi::where('user_id', $user->id)->whereBetween('roi_last_paid', [$dateFrom, $dateTo])->sum('roi');
                $previousWeeklyRoi = Roi::where('user_id', $user->id)->whereBetween('created_at', [$previousDateFrom, $previousDateTo])->sum('roi');
                $total = $weeklyRoi + $previousWeeklyRoi;
                return $total;
            } else {
                $weeklyRoi = Roi::where('user_id', $user->id)->whereBetween('roi_last_paid', [$dateFrom, $dateTo])->sum('roi');
                $total = $weeklyRoi;
                return $total;
            }
        } else {
            return 0;
        }
    }
}

/**
 * convert showSingleTree  of a user to a list
 */
