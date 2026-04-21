<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->unsignedBigInteger('local_id')->nullable()->after('module_id');
            $table->foreign('local_id')->references('id')->on('locals')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->dropForeign(['local_id']);
            $table->dropColumn('local_id');
        });
    }
};
