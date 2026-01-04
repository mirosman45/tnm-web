<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // admin, editor, user
            $table->boolean('can_comment')->default(false);
            $table->boolean('can_view_old_news')->default(false);
            $table->boolean('blocked')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'can_comment', 'can_view_old_news', 'blocked']);
        });
    }
};
