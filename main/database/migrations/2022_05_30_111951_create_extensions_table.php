<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->string('act');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->text('script');
            $table->text('shortcode');
            $table->text('support');
            $table->tinyInteger('status')->default(1);
            $table->dateTime('deleted_at');
            $table->timestamps();
        });
        $sql = file_get_contents(__DIR__ . '/extension.sql');
        DB::statement($sql);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extensions');
    }
};
