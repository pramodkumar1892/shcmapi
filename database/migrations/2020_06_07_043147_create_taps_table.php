<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taps', function (Blueprint $table) {
            $table->id();
            $table->string('tap_parent_id', 250);
            $table->string('tap_collection_id', 250)->unique();
            $table->integer('user_id');

            //$table->time('tap_in');
            //$table->time('tap_out');

            //$table->string('tap_type', 50);
            $table->timestamp('tap_in')->nullable();
            $table->timestamp('tap_out')->nullable();
            $table->date('tap_date');
            //$table->time('tap_time');
            $table->string('tap_day', 50);
            $table->timestamps();

            //$table->unique(['tap_collection_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taps');
    }
}
