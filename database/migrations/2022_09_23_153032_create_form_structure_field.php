<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormStructureField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_structure_field_new', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id')->nullable();
            $table->integer('form_structure_id')->nullable();
            $table->string('field_type')->nullable();
            $table->string('field_name')->nullable();
            $table->enum('status',[0,1])->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('form_structure_field');
    }
}
