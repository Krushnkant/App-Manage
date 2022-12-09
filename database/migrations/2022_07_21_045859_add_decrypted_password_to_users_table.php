<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDecryptedPasswordToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->string('decrypted_password')->nullable();
            $table->enum('role', [1, 2, 3])->nullable()->comment('1->Admin,2->Sub Admin,3->End User');
            $table->string('mobile_no')->nullable();
            $table->string('profile_pic')->nullable();
            $table->enum('gender', [1, 2, 3])->default(1)->comment('1->Female,2->Male,3->Other');
            $table->enum('estatus', [1, 2, 3, 4])->default(1)->comment('1->Active,2->Deactive,3->Deleted,4->Pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_table', function (Blueprint $table) {
            //
        });
    }
}
