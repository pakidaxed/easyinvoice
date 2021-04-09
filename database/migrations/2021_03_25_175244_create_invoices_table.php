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
            $table->increments('id');
            $table->integer('number')->unsigned(); // 1
            $table->string('invoice_number'); // PREFIX000001
            $table->integer('payment_term')->unsigned();
            $table->float('sum_excl_tax');
            $table->float('sum_incl_tax');
            $table->integer('user_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->integer('client_id')->unsigned();
            $table->boolean('paid')->default(false);
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
