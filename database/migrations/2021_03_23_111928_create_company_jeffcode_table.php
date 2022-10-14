<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyJeffcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_jeffcode', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained('companies')            
            ->onUpdate('cascade')
            ->onDelete('cascade');;
            $table->foreignId('jeffcode_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_jeffcode');
    }
}
