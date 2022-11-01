<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateC8CJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c8_c_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idjob');
            $table->string('job_code')->default('');
            $table->text('jobdescription')->nullable();
            $table->text('company')->nullable();
            $table->text('description')->nullable();
            $table->string('jobtypeKey')->nullable();
            $table->string('status')->nullable();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('idtranslator')->nullable();
            $table->json('othertranslator')->nullable();
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
        Schema::dropIfExists('c8_c_jobs');
    }
}
