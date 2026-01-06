<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp', 6)->nullable()->after('password'); // store 6-digit OTP
            $table->timestamp('otp_expires_at')->nullable()->after('otp'); // OTP expiration
            $table->boolean('is_verified')->default(false)->after('otp_expires_at'); // verified status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at', 'is_verified']);
        });
    }
};
