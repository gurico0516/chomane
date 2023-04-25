<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('allowance_id')->comment('お小遣いID');
            $table->string('expence')->comment('経費データ');
            $table->string('memo')->comment('経費メモ');
            $table->string('type')->comment('経費種別、1:雑費、2:食費、3:消耗品費、4:交通費');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('expenses');
    }
};
