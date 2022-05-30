<?php

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
        Schema::create('withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->decimal('min_limit', 18, 8)->default(0.00000000);
            $table->decimal('max_limit', 18, 8)->default(0.00000000);
            $table->string('delay')->nullable();
            $table->decimal('fixed_charge', 18, 8)->default(0.00000000);
            $table->decimal('rate', 18, 8)->default(0.00000000);
            $table->decimal('percent_charge', 18, 8)->default(0.00000000);
            $table->string('currency')->nullable();
            $table->text('user_data')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=active, 0=inactive');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraw_methods');
    }
};
