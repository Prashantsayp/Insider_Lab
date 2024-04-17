<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 220);
            $table->string('last_name', 220);
            $table->string('mobile', 15);
            $table->string('pin_code', 8);
            $table->text('pan_card', 255);
            $table->timestamp('date_of_birth')->nullable();
            $table->string('company', 255);
            $table->text('field_of_work');
            $table->string('designation', 255);
            $table->string('monthly_salary', 10);
            $table->string('monthly_emi', 10)->nullable();
            $table->string('load_type', 255);
            $table->string('load_amount', 12);
            $table->enum('mode_of_salary', ["cash", "cheque", "bank"]);
            $table->string('salary_bank', 255)->nullable();
            $table->text('load_purpose');
            $table->bigInteger("assigned_to");
            $table->bigInteger("created_by");
            $table->string("status")->default("new");
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
        Schema::drop('cases');
    }
}
