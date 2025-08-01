<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['boolean', 'integer', 'double', 'string', 'NULL', 'array']);
            $table->string('key');
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->mediumText('value')->nullable();
            $table->boolean('is_encrypted')->default(false);
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_settings');
    }
}
