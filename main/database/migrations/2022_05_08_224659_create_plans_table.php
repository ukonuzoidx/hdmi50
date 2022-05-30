<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Plan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('pv');
            $table->decimal('ref_com', 16, 8)->default(0.00000000);
            $table->decimal('tree_com', 16, 8)->default(0.00000000);
            $table->decimal('price', 16, 8)->default(0.00000000);
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->timestamps();
        });

        $plans = Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'pv' => 75,
            'ref_com' => 6,
            'tree_com' => 7.5,
            'price' => '75',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'pv' => 100,
            'ref_com' => 8,
            'tree_com' => 10,
            'price' => '100',
            'status' => 1,
        ]);




    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
