<?php

use App\Enums\CouponDuration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('percent_off')->nullable();
            $table->enum('duration', array_column(CouponDuration::cases(), 'value'));
            $table->integer('duration_in_months')->nullable(); // if duration is repeating
            $table->string('stripe_id')->nullable()->unique();
            $table->integer('max_redemptions')->nullable();
            $table->timestamp('redeem_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
