<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockAndPriceToProductDataTable extends Migration
{
    public function up(): void
    {
        Schema::table('tblProductData', function (Blueprint $table) {
            $table->integer('intStock')->after('strProductCode')->default(0);
            $table->decimal('decPrice', 8, 2)->after('intStock')->default(0.00);
        });
    }

    public function down(): void
    {
        Schema::table('tblProductData', function (Blueprint $table) {
            $table->dropColumn(['intStock', 'decPrice']);
        });
    }
}
