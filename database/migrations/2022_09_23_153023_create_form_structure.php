<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_structure_new', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('form_title')->nullable();
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
        Schema::dropIfExists('form_structure');
    }
}
