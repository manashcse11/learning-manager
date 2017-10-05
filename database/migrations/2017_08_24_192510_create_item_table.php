<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('item_id')->unsigned();
            $table->integer('level_id')->unsigned()->default(1);
            $table->integer('type_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned()->default(1);
            $table->integer('item_parent_id')->unsigned()->default(0);
            $table->string('item_title')->unique();
            $table->string('item_description')->nullable();
            $table->string('item_outcome')->nullable();
            $table->integer('item_priority')->unsigned()->default(1);
            $table->float('item_point')->default(1);
            $table->date('item_due_date')->default(date('Y-m-d'));
            $table->tinyInteger('status_id')->default(1);
            $table->integer('color_id')->unsigned()->default(1);
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
        Schema::dropIfExists('items');
    }
}
