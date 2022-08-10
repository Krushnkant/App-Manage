<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsurlToApplicationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_data', function (Blueprint $table) {
            $table->enum('is_url', [0, 1])->default(0)->after('name');
            $table->string('icon_url')->after('icon')->nullable();
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
