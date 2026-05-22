<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add total_amount for the Ledger
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 8, 2)->default(0)->after('canteen_id');
            }
            
            // Add ticket_number for the Live Dashboard
            if (!Schema::hasColumn('orders', 'ticket_number')) {
                $table->string('ticket_number')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('orders', 'ticket_number')) {
                $table->dropColumn('ticket_number');
            }
        });
    }
};