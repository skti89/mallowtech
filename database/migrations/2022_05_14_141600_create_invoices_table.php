<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('customer_email');
            $table->float('bill_total', 8, 2);
            $table->float('bill_total_rounded', 8, 2);
            $table->float('balance_returned', 8, 2);
            $table->float('amount_collected', 8, 2);
            $table->integer('collected_500')->nullable();
            $table->integer('collected_200')->nullable();
            $table->integer('collected_100')->nullable();
            $table->integer('collected_50')->nullable();
            $table->integer('collected_20')->nullable();
            $table->integer('collected_10')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
