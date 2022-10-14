<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_customer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('contact_id');
            $table->boolean('has_email')->default(0);
            $table->boolean('has_phone')->default(0);
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
        Schema::dropIfExists('contact_customer');
    }
}
