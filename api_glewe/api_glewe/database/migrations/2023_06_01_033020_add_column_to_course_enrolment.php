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
        Schema::table('course_enrolment', function (Blueprint $table) {
            //
            if (Schema::hasColumn('courses', 'is_finish')){
                Schema::table('courses', function (Blueprint $table) {
                    $table->boolean('is_finish');
           });}
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_enrolment', function (Blueprint $table) {
            //
        });
    }
};
