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
            $table->decimal('amount', 16, 8)->default(0.00000000);
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => 'EPIN1',  // EPIN1
            'status' => '1',
            'amount' => '100',
        ]);
        $epins = Epin::create([
            // 'user_id' => 2,
            'epin' => 'EPIN2',  // EPIN1
            'status' => '0',
            'amount' => '75',
        ]);
        $epins = Epin::create([
            // 'user_id' => 3,
            'epin' => 'EPIN3',  // EPIN1
            'status' => '0',
            'amount' => '100',
        ]);

        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => 'EPIN4',  // EPIN1
            'status' => '0',
            'amount' => '50',
        ]);
        $epins = Epin::create([
            // 'user_id' => 2,
            'epin' => 'EPIN5',  // EPIN1
            'status' => '0',
            'amount' => '175',
        ]);
        $epins = Epin::create([
            // 'user_id' => 3,
            'epin' => 'EPIN6',  // EPIN1
            'status' => '0',
        ]);

        $epins = Epin::create([
            // 'user_id' => 1,
            'epin' => 'EPIN7',  // EPIN1
            'status' => '0',
        ]);
        $epins = Epin::create([
            // 'user_id' => 2,
            'epin' => 'EPIN8',  // EPIN1
            'status' => '0',
        ]);
        $epins = Epin::create([
            // 'user_id' => 3,
            'epin' => 'EPIN9',  // EPIN1
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
