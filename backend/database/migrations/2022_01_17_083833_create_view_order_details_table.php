<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_details AS (
            SELECT o.id as order_id, d.id as detail_id, p.name, p.cover_path, p.price as product_price, d.quantity, o.price as order_price
            FROM orders o
            RIGHT JOIN order_details d ON o.id = d.order_id
            RIGHT JOIN products p ON p.id = d.product_id
            WHERE o.id IS NOT NULL )");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_order_details');
    }
}
