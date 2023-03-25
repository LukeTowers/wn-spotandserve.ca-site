<?php

namespace SAS\Requests\Updates;

use SAS\Requests\Models\RequestType;
use Schema;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sas_requests_request_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->mediumText('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $types = [
            ['Cleanup', 'cleanup'],
            ['Snow clearing', 'snow-clearing'],
            ['Other', 'other'],
        ];

        $typeData = [];
        $now = now()->toDateTimeString();
        foreach ($types as $type) {
            $typeData[] = [
                'name' => $type[0],
                'slug' => $type[1],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        RequestType::insert($typeData);
    }

    public function down()
    {
        Schema::dropIfExists('sas_requests_request_types');
    }
};
