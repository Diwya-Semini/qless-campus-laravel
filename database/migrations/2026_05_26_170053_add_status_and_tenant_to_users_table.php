<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Change the default role value seamlessly if needed
            $table->string('role')->default('student')->change(); 
            
            // 2. Add the approval status column cleanly without touching canteen_id
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('approved');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};