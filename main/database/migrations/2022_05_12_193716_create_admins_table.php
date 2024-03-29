<?php

use App\Models\Admin;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->text('access');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'username' => '@hdmi@',
            'password' => bcrypt('18.1,13,1,4,1,14,1jaden'),
            'access' => '["admin"]',

        ]);
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
