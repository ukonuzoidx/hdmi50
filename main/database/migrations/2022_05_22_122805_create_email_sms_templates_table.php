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
        Schema::create('email_sms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('act');
            $table->string('name');
            $table->string('subj');
            $table->text('email_body');
            $table->text('sms_body');
            $table->text('shortcodes');
            $table->tinyInteger('email_status')->default(1);
            $table->tinyInteger('sms_status')->default(1);
            $table->timestamps();
        });
        // insert into tables from file
        $sql = file_get_contents(__DIR__ . '/email_sms_templates.sql');
        // DB::table('email_sms_templates')->insert();
        DB::statement($sql);


    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_sms_templates');
    }
};
