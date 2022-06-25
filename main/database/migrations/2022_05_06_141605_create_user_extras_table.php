<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserExtra;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_extras', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('paid_left')->default(0);
            $table->integer('paid_right')->default(0);
            $table->decimal('lpv', 16, 8)->default(0.00000000);
            $table->decimal('rpv', 16, 8)->default(0.00000000);
            $table->decimal('pv_left', 16, 8)->default(0.00000000);
            $table->decimal('shiba_left', 16, 8)->default(0.00000000);
            $table->decimal('pv_right', 16, 8)->default(0.00000000);
            $table->decimal('shiba_right', 16, 8)->default(0.00000000);
            $table->timestamps();
        });
        $user_extras = UserExtra::create([
            'user_id' => 1,
            'paid_left' => 0,
            'paid_right' => 0,
            'lpv' => 0,
            'rpv' => 0,
            'pv_left' => 1000,
            'shiba_left' => 500,
            'pv_right' => 400,
            'shiba_right' => 400,
        ]);
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_extras');
    }
};
