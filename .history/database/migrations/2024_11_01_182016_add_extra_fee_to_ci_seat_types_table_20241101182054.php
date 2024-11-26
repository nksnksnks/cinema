<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_seat_types', function (Blueprint $table) {
            $table->integer('extra_fee')->default(0)->after('seat_type'); // Thêm cột extra_fee
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_seat_types', function (Blueprint $table) {
            //
        });
    }
};
