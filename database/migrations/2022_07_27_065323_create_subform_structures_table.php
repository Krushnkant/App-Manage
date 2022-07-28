<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubformStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subform_structures', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id');
            $table->integer('form_id');
            $table->string('field_name');
            $table->string('field_type');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('status')->default(1)->comment('1->Active,2->Deactive');
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
        Schema::dropIfExists('subform_structures');
    }
}
