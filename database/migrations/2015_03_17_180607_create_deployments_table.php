<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deployments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('committer');
            $table->string('commit');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->enum('status', ['Pending', 'Deploying', 'Completed', 'Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deployments');
    }
}
