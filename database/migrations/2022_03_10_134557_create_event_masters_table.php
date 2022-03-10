<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_masters', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('title',250)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('occurrence_repeat')->default(1)->comment('1 for repeat every day/third etc,0 for repeat on occation ');
            $table->enum('occurrence_every',['Every','Every Other','Every Third','Every Fourth'])->nullable();
            $table->enum('occurrence_every_period',['Day','Week','Month','Year'])->nullable();
            $table->enum('occurrence_duration',['First','Second','Third','Fourth'])->nullable();
            $table->enum('occurrence_weekday',['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'])->nullable();
            $table->enum('occurrence_monthly',['Month','3 Months','4 Months','6 Months','Year'])->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('event_masters');
    }
}
