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
        Schema::table('courses', function (Blueprint $table) {

        if (Schema::hasColumn('courses', 'course_type')){
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('course_type');
       });}
       if (Schema::hasColumn('courses', 'course_level')){
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('course_level');
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
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
};
