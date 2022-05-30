<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function cron()
    {
        $gnl = GeneralSetting::first();
        $gnl->last_cron = Carbon::now()->toDateTimeString();
        $gnl->save();

        // if ($gnl->matching_bonus_time == 'daily') {
        //     $day = Date('H');
        //     if (strtolower($day) != $gnl->matching_when) {

        if (Carbon::now()->toDateString() == Carbon::parse($gnl->last_paid)->toDateString()) {
            /////// pv done for today '------'
            ///////////////////LETS PAY THE BONUS

            $gnl->last_paid = Carbon::now()->toDateString();
            $gnl->save();

            $eligibleUsers = UserExtra::where('pv_left', '>=', $gnl->total_pv)->where('pv_right', '>=', $gnl->total_pv)->get();
            foreach ($eligibleUsers as $uex) {
                $user = $uex->user;
                $weak = $uex->pv_left < $uex->pv_right ? $uex->pv_left : $uex->pv_right;
                $weaker = $weak < $gnl->max_pv ? $weak : $gnl->max_pv;

                dd($user);


                $pair = intval($weaker / $gnl->total_pv);

                $bonus = $pair * $gnl->pv_price;

                // add balance to User

                $payment = User::find($uex->user_id);
                $payment->balance += $bonus;
                $payment->save();

                $trx = new Transaction();
                $trx->user_id = $payment->id;
                $trx->amount = $bonus;
                $trx->charge = 0;
                $trx->trx_type = '+';
                $trx->post_balance = $payment->balance;
                $trx->remark = 'binary_commission';
                $trx->trx = getTrx();
                $trx->details = 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $pair * $gnl->total_pv . ' PV.';
                $trx->save();

                notify($user, 'matching_bonus', [
                    'amount' => $bonus,
                    'currency' => $gnl->cur_text,
                    'paid_pv' => $pair * $gnl->total_pv,
                    'post_balance' => $payment->balance,
                    'trx' =>  $trx->trx,
                ]);

                $paidpv = $pair * $gnl->total_pv;
                if ($gnl->cary_flash == 0) {
                    $pv['setl'] = $uex->pv_left - $paidpv;
                    $pv['setr'] = $uex->pv_right - $paidpv;
                    $pv['paid'] = $paidpv;
                    $pv['lostl'] = 0;
                    $pv['lostr'] = 0;
                }
                if ($gnl->cary_flash == 1) {
                    $pv['setl'] = $uex->pv_left - $weak;
                    $pv['setr'] = $uex->pv_right - $weak;
                    $pv['paid'] = $paidpv;
                    $pv['lostl'] = $weak - $paidpv;
                    $pv['lostr'] = $weak - $paidpv;
                }
                if ($gnl->cary_flash == 2) {
                    $pv['setl'] = 0;
                    $pv['setr'] = 0;
                    $pv['paid'] = $paidpv;
                    $pv['lostl'] = $uex->pv_left - $paidpv;
                    $pv['lostr'] = $uex->pv_right - $paidpv;
                }
                $uex->pv_left = $pv['setl'];
                $uex->pv_right = $pv['setr'];
                $uex->save();


                if ($pv['paid'] != 0) {
                    createPVLog($payment->id, 1, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
                    createPVLog($payment->id, 2, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
                }
                if ($pv['lostl'] != 0) {
                    createPVLog($payment->id, 1, $pv['lostl'], 'Flush ' . $pv['lostl'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
                }
                if ($pv['lostr'] != 0) {
                    createPVLog($payment->id, 2, $pv['lostr'], 'Flush ' . $pv['lostr'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
                }
            }
            //             return '1';
        }
        //     }
        // }

        // if ($gnl->matching_bonus_time == 'weekly') {
        //     $day = Date('D');
        //     if (strtolower($day) != $gnl->matching_when) {
        //         if (Carbon::now()->toDateString() == Carbon::parse($gnl->last_paid)->toDateString()) {
        //             /////// pv done for today '------'
        //             ///////////////////LETS PAY THE BONUS

        //             $gnl->last_paid = Carbon::now()->toDateString();
        //             $gnl->save();

        //             $eligibleUsers = UserExtra::where('pv_left', '>=', $gnl->total_pv)->where('pv_right', '>=', $gnl->total_pv)->get();
        //             foreach ($eligibleUsers as $uex) {
        //                 $user = $uex->user;
        //                 $weak = $uex->pv_left < $uex->pv_right ? $uex->pv_left : $uex->pv_right;
        //                 $weaker = $weak < $gnl->max_pv ? $weak : $gnl->max_pv;

        //                 $pair = intval($weaker / $gnl->total_pv);

        //                 $bonus = $pair * $gnl->pv_price;

        //                 // add balance to User

        //                 $payment = User::find($uex->user_id);
        //                 $payment->balance += $bonus;
        //                 $payment->save();

        //                 $trx = new Transaction();
        //                 $trx->user_id = $payment->id;
        //                 $trx->amount = $bonus;
        //                 $trx->charge = 0;
        //                 $trx->trx_type = '+';
        //                 $trx->post_balance = $payment->balance;
        //                 $trx->remark = 'binary_commission';
        //                 $trx->trx = getTrx();
        //                 $trx->details = 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $pair * $gnl->total_pv . ' PV.';
        //                 $trx->save();

        //                 notify($user, 'matching_bonus', [
        //                     'amount' => $bonus,
        //                     'currency' => $gnl->cur_text,
        //                     'paid_pv' => $pair * $gnl->total_pv,
        //                     'post_balance' => $payment->balance,
        //                     'trx' =>  $trx->trx,
        //                 ]);

        //                 $paidpv = $pair * $gnl->total_pv;
        //                 if ($gnl->cary_flash == 0) {
        //                     $pv['setl'] = $uex->pv_left - $paidpv;
        //                     $pv['setr'] = $uex->pv_right - $paidpv;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = 0;
        //                     $pv['lostr'] = 0;
        //                 }
        //                 if ($gnl->cary_flash == 1) {
        //                     $pv['setl'] = $uex->pv_left - $weak;
        //                     $pv['setr'] = $uex->pv_right - $weak;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = $weak - $paidpv;
        //                     $pv['lostr'] = $weak - $paidpv;
        //                 }
        //                 if ($gnl->cary_flash == 2) {
        //                     $pv['setl'] = 0;
        //                     $pv['setr'] = 0;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = $uex->pv_left - $paidpv;
        //                     $pv['lostr'] = $uex->pv_right - $paidpv;
        //                 }
        //                 $uex->pv_left = $pv['setl'];
        //                 $uex->pv_right = $pv['setr'];
        //                 $uex->save();


        //                 if ($pv['paid'] != 0) {
        //                     createPVLog($payment->id, 1, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                     createPVLog($payment->id, 2, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //                 if ($pv['lostl'] != 0) {
        //                     createPVLog($payment->id, 1, $pv['lostl'], 'Flush ' . $pv['lostl'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //                 if ($pv['lostr'] != 0) {
        //                     createPVLog($payment->id, 2, $pv['lostr'], 'Flush ' . $pv['lostr'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //             }
        //             return '2';
        //         }
        //     }
        // }

        // if ($gnl->matching_bonus_time == 'monthly') {
        //     $day = Date('d');
        //     if (strtolower($day) != $gnl->matching_when) {
        //         if (Carbon::now()->toDateString() == Carbon::parse($gnl->last_paid)->toDateString()) {
        //             /////// pv done for today '------'
        //             ///////////////////LETS PAY THE BONUS

        //             $gnl->last_paid = Carbon::now()->toDateString();
        //             $gnl->save();

        //             $eligibleUsers = UserExtra::where('pv_left', '>=', $gnl->total_pv)->where('pv_right', '>=', $gnl->total_pv)->get();
        //             foreach ($eligibleUsers as $uex) {
        //                 $user = $uex->user;
        //                 $weak = $uex->pv_left < $uex->pv_right ? $uex->pv_left : $uex->pv_right;
        //                 $weaker = $weak < $gnl->max_pv ? $weak : $gnl->max_pv;

        //                 $pair = intval($weaker / $gnl->total_pv);

        //                 $bonus = $pair * $gnl->pv_price;

        //                 // add balance to User

        //                 $payment = User::find($uex->user_id);
        //                 $payment->balance += $bonus;
        //                 $payment->save();

        //                 $trx = new Transaction();
        //                 $trx->user_id = $payment->id;
        //                 $trx->amount = $bonus;
        //                 $trx->charge = 0;
        //                 $trx->trx_type = '+';
        //                 $trx->post_balance = $payment->balance;
        //                 $trx->remark = 'binary_commission';
        //                 $trx->trx = getTrx();
        //                 $trx->details = 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $pair * $gnl->total_pv . ' PV.';
        //                 $trx->save();

        //                 notify($user, 'matching_bonus', [
        //                     'amount' => $bonus,

        //                     'currency' => $gnl->cur_text,
        //                     'paid_pv' => $pair * $gnl->total_pv,
        //                     'post_balance' => $payment->balance,
        //                     'trx' =>  $trx->trx,
        //                 ]);

        //                 $paidpv = $pair * $gnl->total_pv;
        //                 if ($gnl->cary_flash == 0) {
        //                     $pv['setl'] = $uex->pv_left - $paidpv;
        //                     $pv['setr'] = $uex->pv_right - $paidpv;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = 0;
        //                     $pv['lostr'] = 0;
        //                 }
        //                 if ($gnl->cary_flash == 1) {
        //                     $pv['setl'] = $uex->pv_left - $weak;
        //                     $pv['setr'] = $uex->pv_right - $weak;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = $weak - $paidpv;
        //                     $pv['lostr'] = $weak - $paidpv;
        //                 }
        //                 if ($gnl->cary_flash == 2) {
        //                     $pv['setl'] = 0;
        //                     $pv['setr'] = 0;
        //                     $pv['paid'] = $paidpv;
        //                     $pv['lostl'] = $uex->pv_left - $paidpv;
        //                     $pv['lostr'] = $uex->pv_right - $paidpv;
        //                 }
        //                 $uex->pv_left = $pv['setl'];
        //                 $uex->pv_right = $pv['setr'];
        //                 $uex->save();


        //                 if ($pv['paid'] != 0) {
        //                     createPVLog($payment->id, 1, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                     createPVLog($payment->id, 2, $pv['paid'], 'Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //                 if ($pv['lostl'] != 0) {
        //                     createPVLog($payment->id, 1, $pv['lostl'], 'Flush ' . $pv['lostl'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //                 if ($pv['lostr'] != 0) {
        //                     createPVLog($payment->id, 2, $pv['lostr'], 'Flush ' . $pv['lostr'] . ' PV after Paid ' . $bonus . ' ' . $gnl->cur_text . ' For ' . $paidpv . ' PV.');
        //                 }
        //             }
        //             return '3';
        //         }
        //     }
        // }
    }
}
