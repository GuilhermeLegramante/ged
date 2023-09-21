<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_persons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('document_id');
            $table->integer('person_id');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('document_id')
                ->references('id')
                ->on('documents')
                ->onDelete('cascade');
            $table->foreign('person_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_persons');
    }
}
