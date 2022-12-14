<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c8_c_jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('idtranslator')->nullable()->after('idjob');
            $table->json('othertranslator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c8_c_jobs', function (Blueprint $table) {
            $table->dropColumn('idtranslator');
            $table->dropColumn('othertranslator');
            //
        });
    }
};
