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
            $table->string('user_id')->nullable();
            $table->integer('plan_id')->default(0);
            $table->decimal('roi', 18, 8)->default(0.00000000);
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
