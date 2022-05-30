<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('ref_id');
            $table->integer('pos_id');
            $table->integer('position');
            // $table->integer('plan_id')->default(0);
           // subscribe to many packages
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username');
            $table->string('sponsor_id');
            $table->string('placer_id');
            $table->string('left_side')->default(0);
            $table->string('right_side')->default(0);
            $table->string('epin')->unique();
            $table->string('pin')->unique()->required();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone');
            $table->decimal('subscribed_amount', 16, 8)->default(0.00000000);
            $table->decimal('balance', 18, 8)->default(0.00000000);
            $table->decimal('total_ref_com', 18, 8)->default(0.00000000);
            $table->decimal('total_binary_com', 18, 8)->default(0.00000000);
            $table->decimal('total_invest', 18, 8)->default(0.00000000);
            $table->string('image')->nullable();
            $table->string('ver_code')->nullable()->comment('Verification Code');
            $table->string('ver_code_sent_at')->nullable()->comment('Verification Code Sent At');
            $table->tinyInteger('status')->comment('0: Inactive, 1: Active, 2: Banned');
            $table->json('address')->nullable()->comment('Contains full address');
            $table->tinyInteger('ev')->comment('0: email unverified, 1: email verified');
            $table->tinyInteger('sv')->comment('0: sms unverified, 1: sms verified');
            $table->tinyInteger('ts')->comment('0: 2fa off, 1: 2fa on');
            $table->tinyInteger('tv')->comment('0: 2fa not verified, 1: 2fa verified');
            $table->rememberToken();
            $table->timestamps();
        });

        $users = User::create([
            'pos_id' => 0,
            'ref_id' => 0,
            'position' => 0,
            // 'plan_id' => 0,
            'user_id' => "12344",
            'firstname' => 'John',
            'lastname' => 'Doe',
            'username' => 'johndoe',
            'sponsor_id' => 'HDMI5020',
            'placer_id' => "HDMI5030",
            'epin' => 'EPIN1',
            'pin' => bcrypt('123456'),
            'balance' => 1000.00000000,
            'email' => 'johndoe@email.com',
            'password' => Hash::make('12345678'),
            'phone' => '+234156789012',
            'left_side' => '0',
            'right_side' => '0',
            'image' => NULL,
            'ver_code' => NULL,
            'ver_code_sent_at' => NULL,
            'status' => 1,
            'address' => [
                'address' => 'Address A',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'zip' => '902101',
            ],
            'ev' => 1,
            'sv' => 1,
            'ts' => 1,
            'tv' => 1,
        ]);
  
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};