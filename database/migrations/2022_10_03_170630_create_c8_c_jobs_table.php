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
            $table->integer('job_id');
            $table->string('job_code')->default('');
            $table->text('jobdescription');
            $table->text('company');
            $table->text('description');
            $table->json('meta');
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
