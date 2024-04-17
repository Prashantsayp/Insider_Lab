<?php

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTableAddDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table("users", function(Blueprint $table) {
            $table->string("location")->after('email');
            $table->string("mobile")->after('email');
            $table->timestamp("mobile_verified_at", 0)->after('email')->nullable();
            $table->string("aadhar_card")->after('email');
            $table->string("pan_card")->after('email');
            $table->string("user_type")->after('email')->default('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
