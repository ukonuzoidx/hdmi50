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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('method_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 18, 8);
            $table->string('currency');
            $table->decimal('rate', 18, 8);
            $table->decimal('charge', 18, 8);
            $table->decimal('trx', 18, 8);
            $table->decimal('final_amount', 18, 8);
            $table->string('status')->default(0)->comment('0: Pending, 1: Approved, 2: Cancelled');
            $table->decimal('after_charge', 18, 8);
            $table->text('admin_feedback');
            $table->text('withdraw_information');
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
        Schema::dropIfExists('withdraws');
    }
};
