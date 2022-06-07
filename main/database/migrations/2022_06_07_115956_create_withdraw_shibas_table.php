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
        Schema::create('withdraw_shibas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('shibainu', 18, 8);
            $table->decimal('trx', 18, 8);
            $table->decimal('final_shibainu', 18, 8);
            $table->string('status')->default(0)->comment('0: Pending, 1: Approved, 2: Cancelled');
            $table->text('admin_feedback');
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
        Schema::dropIfExists('withdraw_shibas');
    }
};
