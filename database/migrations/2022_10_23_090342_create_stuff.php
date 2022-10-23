<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stuff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['inactive', 'active', 'blocked'])->default('inactive');
            $table->text('description')->nullable();
            $table->string('contacts');
            $table->string('safe_for_uk')->nullable();
            $table->boolean('online');
            $table->integer('offline_place')->nullable();
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
        Schema::dropIfExists('stuff');
    }
};
