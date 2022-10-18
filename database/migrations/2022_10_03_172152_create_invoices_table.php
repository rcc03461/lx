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
            $table->integer('idtranslation')->nullable();
            $table->integer('task_id')->nullable();
            $table->integer('idjob')->nullable(); //

            $table->integer('lx_number')->nullable(); //

            $table->string('invoiceCode')->nullable(); // C8C
            $table->integer('InvoiceNo')->nullable(); // C8C
            $table->integer('version')->nullable(); // C8C
            $table->integer('ApproveId')->nullable(); // C8C
            $table->integer('Transtatus')->nullable(); // C8C
            $table->dateTime('InvoiceTime')->nullable(); // C8C

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
