<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('flow_id')->unsigned()->nullable(); 
            $table->bigInteger('action_id')->unsigned()->nullable();   
            $table->string('username');
            $table->string('description',500);
            $table->string('type');                      
            //Metadatos
            $table->string('summary',1500);
            $table->string('code',500);
            $table->string('languaje',500);
            $table->string('others',500);
           // $table->string('route',500);
            
            $table->timestamps();

            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('flow_id')->references('id')->on('flows')->onDelete('set null');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('set null');
           

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
