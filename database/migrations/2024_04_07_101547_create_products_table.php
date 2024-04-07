<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->float("price")->default(0);
            $table->bigInteger("count")->default(0);
            $table->tinyInteger("is_active")->default(1);
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->integer("brand_id")->nullable()->constrained()->cascadeOnDelete();
            $table->integer("category_id")->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
