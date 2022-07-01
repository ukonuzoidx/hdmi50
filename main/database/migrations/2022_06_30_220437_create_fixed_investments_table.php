<?php

use App\Models\FixedInvestment;
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
        Schema::create('fixed_investments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 16, 8)->default(0.00000000);
            $table->decimal('charge', 16, 8)->default(0.00000000);
            $table->decimal('fixed_roi', 18, 8)->default(0.00000000);
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->timestamps();
        });

        $fixed_investments = FixedInvestment::create([
            'name' => 'Starter',
            'slug' => 'starter',
            'price' => '100',
            'charge' => '25',
            'fixed_roi' => '0.75',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => '500',
            'charge' => '25',
            'fixed_roi' => '375',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'price' => '2500',
            'charge' => '25',
            'fixed_roi' => '1875',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Platinum',
            'slug' => 'platinum',
            'price' => '10000',
            'charge' => '25',
            'fixed_roi' => '7500',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => '25000',
            'charge' => '25',
            'fixed_roi' => '18750',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Gold',
            'slug' => 'gold',
            'price' => '50000',
            'charge' => '25',
            'fixed_roi' => '37500',
            'status' => 1,
        ]);
        $fixed_investments = FixedInvestment::create([
            'name' => 'Vip',
            'slug' => 'vip',
            'price' => '100000',
            'charge' => '25',
            'fixed_roi' => '75000',
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
        Schema::dropIfExists('fixed_investments');
    }
};
