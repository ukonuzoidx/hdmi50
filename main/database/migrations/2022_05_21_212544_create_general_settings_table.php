<?php

use App\Models\GeneralSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sitename')->nullable();
            $table->string('cur_text')->nullable()->comment("Currency text");
            $table->string('cur_sym')->nullable()->comment("Currency symbol");
            $table->string('email_from')->nullable();
            $table->text('email_template')->nullable();
            $table->string('base_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->text('mail_config')->nullable();
            $table->string('signup_bonus')->nullable();
            $table->string('shiba_bonus')->nullable();
            $table->tinyInteger('ev')->nullable()->comment('email verification, 0: dont send, 1: send');
            $table->tinyInteger('en')->nullable()->comment('email notification, 0: dont send, 1: send	');
            $table->tinyInteger('sv')->nullable()->comment('sms verification, 0: dont send, 1: send');
            $table->tinyInteger('sn')->nullable()->comment('sms notification, 0: dont send, 1: send');
            $table->tinyInteger('force_ssl')->default(0)->comment('0: dont force, 1: force');
            $table->tinyInteger('secure_password')->default(0);
            $table->tinyInteger('registration')->default(0)->comment('0: disable, 1: enable');
            $table->tinyInteger('social_login')->default(0)->comment('0: disable, 1: enable');
            $table->text('social_credential')->nullable();
            $table->text('sys_version')->nullable();
            $table->string('active_template')->nullable();
            $table->integer('agree_policy')->default(0)->comment('0: disable, 1: enable');
            $table->string('pv_price')->nullable();
            $table->string('total_pv')->nullable();
            $table->integer('max_pv')->nullable();
            $table->binary('notice')->nullable();
            $table->binary('free_user_notice')->nullable();
            $table->string('matching_bonus_time')->nullable();
            $table->string('matching_when')->nullable();
            $table->dateTime('last_paid')->nullable();
            $table->dateTime('last_cron')->nullable();
            $table->decimal('bal_trans_per_charge', 18, 8)->default(0.000000);
            $table->decimal('bal_trans_fixed_charge', 18, 8)->default(0.000000);
            $table->timestamps();
        });

        $general_settings = GeneralSetting::create([
            'sitename' => 'HD-MLM',
            'cur_text' => 'USD',
            'cur_sym' => '$',
            'email_from' => 'no-reply@hdmlm.com',
            'email_template' => '<table style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#001736"><tbody><tr><td valign="top" align="center"><table class="mobile-shell" width="650" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="td container" style="width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;"><div style="text-align: center;"><img src="https://i.imgur.com/C9IS7Z1.png" style="height: 240 !important;width: 338px;margin-bottom: 20px;"></div><table style="width: 650px; margin: 0px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-bottom: 10px;"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="tbrr p30-15" style="padding: 60px 30px; border-radius: 26px 26px 0px 0px;" bgcolor="#000036"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;">Hi {{name}} ,</td></tr><tr><td style="color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;">{{message}}</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style="width: 650px; margin: 0px auto;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="p30-15 bbrr" style="padding: 50px 30px; border-radius: 0px 0px 26px 26px;" bgcolor="#000036"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="text-footer1 pb10" style="color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;">© 2021 HD-Mlm. All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>',
            'base_color' => '7376E7',
            'secondary_color' => '47498f',
            'mail_config' => [
                'name' => 'smtp',
                'host' => 'smtp.mailtrap.io',
                'port' => 2525,
                'username' => '1cfbf921dfbdc2',
                'password' => 'c2e76dcbaea7f6',
                'encryption' => 'tls',
            ],
            'ev' => 1,
            'en' => 1,
            'sv' => 1,
            'sn' => 1,
            'signup_bonus' => '150',
            'shiba_bonus' => '200000',
            'force_ssl' => 0,
            'secure_password' => 0,
            'registration' => 0,
            'social_login' => 0,
            'social_credential' => '{"facebook":{"app_id":"","app_secret":""},"google":{"app_id":"","app_secret":""},"twitter":{"app_id":"","app_secret":""}}',
            'sys_version' => '1.0.0',
            'active_template' => 'default',
            'agree_policy' => 1,
            'pv_price' => '0.00',
            'total_pv' => '0',
            'max_pv' => '0',
            'notice' => '',
            'free_user_notice' => '',
            'matching_bonus_time' => 'daily',
            'matching_when' => '1',
            'last_paid' => null,
            'last_cron' => null,
            'bal_trans_per_charge' => '1',
            'bal_trans_fixed_charge' => '10'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
};
