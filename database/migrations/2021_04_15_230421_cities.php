<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumInteger('state_id')->unique();
            $table->string('state_code');
            $table->mediumInteger('country_id')->unique();
            $table->char('country_code', 2);
            $table->decimal('latitude',10,8);
            $table->decimal('longitude',10,8);
            $table->tinyInteger('flag',1);
            $table->string('wikiDataId',1);
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
        Schema::dropIfExists('cities');
    }
}
