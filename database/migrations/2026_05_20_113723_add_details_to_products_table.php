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
     Schema::table('products', function (Blueprint $table) {
         // Adds the missing columns if they don't exist yet
         if (!Schema::hasColumn('products', 'category')) {
             $table->string('category')->default('Mains');
         }
         if (!Schema::hasColumn('products', 'imageURL')) {
             $table->string('imageURL')->nullable();
         }
         if (!Schema::hasColumn('products', 'isAvailable')) {
             $table->boolean('isAvailable')->default(true);
         }
     });
 }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
