<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::table('property_images', function (Blueprint $table) {
        $table->unsignedBigInteger('property_id');
        $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('property_images', function (Blueprint $table) {
        $table->dropForeign(['property_id']);
        $table->dropColumn('property_id');
    });
}
};
