<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_menu', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('nav_id');
            $table->string('title');
            $table->string('position');
            $table->boolean('status')->default(0);
            $table->timestamps();

        });

        Schema::create('nav_menu_link', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('nav_id');
            $table->string('title',255);
            $table->string('type',20);
            $table->string('link',250);
            $table->string('image',255)->nullable();
            $table->string('class')->nullable();
            $table->integer('parent');
            $table->string( 'permission',255)->nullable();
            $table->integer('sortable')->default(0);
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('nav_menu');
        Schema::dropIfExists('nav_menu_link');
        Schema::enableForeignKeyConstraints();
    }
}
