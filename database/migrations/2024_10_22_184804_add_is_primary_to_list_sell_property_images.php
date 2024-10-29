<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('list_sell_property_images', function (Blueprint $table) {
            $table->boolean('is_primary')->default(false)->after('image_path');
        });
    }

    public function down()
    {
        Schema::table('list_sell_property_images', function (Blueprint $table) {
            $table->dropColumn('is_primary');
        });
    }
};
