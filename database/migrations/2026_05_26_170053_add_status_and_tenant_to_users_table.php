<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role configuration fallback protection
            $table->string('role')->default('student')->change(); 
            
            // Onboarding check constraints
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('approved'); // Default approved for admins/students
            $table->foreignId('canteen_id')->nullable()->constrained('canteens')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'canteen_id']);
        });
    }
};