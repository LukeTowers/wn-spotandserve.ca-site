<?php

namespace SAS\Requests\Updates;

use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sas_requests_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('type_id')->unsigned()->nullable()->index();
            $table->integer('submitted_by')->unsigned()->nullable()->index();
            $table->integer('resolved_by')->unsigned()->nullable()->index();
            $table->string('status')->default('submitted');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->text('description')->nullable();
            $table->mediumText('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sas_requests_requests');
    }
};
