<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSubField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sub_field', function (Blueprint $table) {
            $table->id();
            $table->integer('app_id')->nullable();
            $table->integer('content_field_id')->nullable();
            $table->string('field_value')->nullable();
            $table->enum('file_type',['image','video'])->nullable();
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
        Schema::dropIfExists('content_sub_field');
    }
}
