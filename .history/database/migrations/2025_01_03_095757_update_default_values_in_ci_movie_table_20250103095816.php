<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('ci_movie', function (Blueprint $table) {
        $table->decimal('voting', 2, 1)->default(0.0)->change();
        $table->unsignedBigInteger('vote_total')->default(0)->change();
    });
}

public function down()
{
    Schema::table('ci_movie', function (Blueprint $table) {
        $table->string('voting')->nullable()->change();
        $table->string('vote_total')->change();
    });
}

};
