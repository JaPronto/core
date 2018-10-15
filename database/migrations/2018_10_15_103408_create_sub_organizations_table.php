<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('founded_at')->nullable();
            $table->string('description');
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('country_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
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
        Schema::dropIfExists('sub_organizations');
    }
}
