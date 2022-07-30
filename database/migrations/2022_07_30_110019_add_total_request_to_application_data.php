<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalRequestToApplicationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_data', function (Blueprint $table) {
            $table->string('total_request')->after('package_name')->nullable();
            $table->string('token')->after('total_request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_data', function (Blueprint $table) {
            //
        });
    }
}
