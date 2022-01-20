<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->from(569878);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('order_status_id')->default(1)->constrained('order_statuses')->cascadeOnDelete();
            $table->string('order_date', 10);
            $table->integer('price');
            $table->text('research_results');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
