<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',25)->nullable();
            $table->string('last_name',25)->nullable();
            $table->string('job',50)->nullable();
            $table->string('work_email',30)->unique()->nullable();
            $table->string('personal_email',30)->unique()->nullable();
            $table->string('mobile_phone_a',20)->unique()->nullable();
            $table->string('mobile_phone_b',20)->unique()->nullable();
            $table->string('direct_phone',20)->unique()->nullable();
            $table->string('office_phone',20)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->default('user.png');
            $table->string('li')->unique()->nullable();
            $table->string('jeffcode')->nullable();
            $table->boolean('ready')->default(0);
            $table->boolean('buyer')->default(0);
            $table->date('last_check')->nullable();
            $table->string('company',50)->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
