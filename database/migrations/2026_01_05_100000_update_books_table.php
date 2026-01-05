<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('books', function (Blueprint $table) {
            // Change file_path to pdf if it exists
            if (Schema::hasColumn('books', 'file_path')) {
                $table->renameColumn('file_path', 'pdf');
            }
            
            // Add user_id foreign key
            if (!Schema::hasColumn('books', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'user_id')) {
                $table->dropForeignKeyIfExists(['user_id']);
                $table->dropColumn('user_id');
            }
            
            if (Schema::hasColumn('books', 'pdf')) {
                $table->renameColumn('pdf', 'file_path');
            }
        });
    }
};
