<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rois', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('plan_id')->nullable();
            $table->decimal('roi', 18, 8)->default(0.00000000);
            // $table->integer('claimed')->default(0);
            // $table->integer('withdrawed')->default(0);
            $table->string('remark')->nullable();
            $table->timestamp('roi_last_paid')->nullable();
            $table->timestamp('roi_last_cron')->nullable();
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
        Schema::dropIfExists('rois');
    }
};
