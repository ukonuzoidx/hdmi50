<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Epin;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epins', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->string('epin')->unique();
            $table->integer('status')->default('0')->comment('0: unused, 1: used');
            $table->integer('type')->nullable()->comment('0: joining, 1: signup');
            $table->integer('sent_by')->nullable();
            $table->integer('recieved_by')->nullable();
            $table->integer('used_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        $epins = Epin::create([
            // 'user_id' => 1,
            // generate pin with substr 
            'epin' => '123456789',
            'status' => '1',
            'user_id' => 1,
            'used_by' => 1,

        ]);
        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => str_random(8),  // EPIN1
            'status' => '0',

        ]);
    
        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => str_random(8),  // EPIN1
            'status' => '0',

        ]);
        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => str_random(8),  // EPIN1
            'status' => '0',

        ]);
        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => str_random(8),  // EPIN1
            'status' => '0',

        ]);
        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => str_random(8),  // EPIN1
            'status' => '0',

        ]);
    

        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epins');
    }
};
