<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cost price (HPP) defaults to 0 if not set
            $table->decimal('cost_price', 12, 2)->default(0)->after('price');
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Snapshot of cost price at moment of sale
            $table->decimal('cost_price', 12, 2)->default(0)->after('unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
    }
};
