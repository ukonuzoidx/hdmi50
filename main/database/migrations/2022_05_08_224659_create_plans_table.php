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
            $table->decimal('roi', 18, 8)->default(0.00000000);
            $table->integer('total_product');
            $table->integer('claim');
                        $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->timestamps();
        });

        $plans = Plan::create([
            'name' => 'Starter',
            'slug' => 'starter',
            'pv' => 200,
            'ref_com' => 16,
            'tree_com' => 20,
            'price' => '200',
            'roi' => '0.699',
            'total_product' => '4',
            'claim' => '1',
            'status' => 1,
        ]);
        $plans = Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'pv' => 1100,
            'ref_com' => 88,
            'tree_com' => 110,
            'price' => '1100',
            'roi' => '3.494',
            'total_product' => '20',
            'claim' => '5',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'pv' => 3300,
            'ref_com' => 88,
            'tree_com' => 264,
            'price' => '3300',
            'roi' => '10.483',
            'total_product' => '60',
            'claim' => '15',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Platinum',
            'slug' => 'platinum',
            'pv' => 9900,
            'ref_com' => 792,
            'tree_com' => 990,
            'price' => '9900',
            'roi' => '31.450',
            'total_product' => '80',
            'claim' => '30',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'pv' => 29700,
            'ref_com' => 2376,
            'tree_com' => 2970,
            'price' => '29700',
            'roi' => '94.350',
            'total_product' => '540',
            'claim' => '90',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Super',
            'slug' => 'super',
            'pv' => 89100,
            'ref_com' => 7128,
            'tree_com' => 8910,
            'price' => '89100',
            'roi' => '283.050',
            'total_product' => '1620',
            'claim' => '135',
            'status' => 1,
        ]);

        $plans = Plan::create([
            'name' => 'Vip',
            'slug' => 'vip',
            'pv' => 266300,
            'ref_com' => 21304,
            'tree_com' => 26630,
            'price' => '266300',
            'roi' => '849.150',
            'total_product' => '4860',
            'claim' => '405',
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
