<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('task_id')->nullable();
            $table->text('tranRemark')->nullable();
            $table->double('total')->nullable();
            $table->date('invoiceDate')->nullable();
            $table->dateTime('reviseDate')->nullable();
            $table->json('words')->nullable();
            $table->jsonb('pages')->nullable();
            $table->json('other')->nullable();
            $table->json('less')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
