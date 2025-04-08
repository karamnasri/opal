<?php

use App\Enums\PrintTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price');
            $table->integer('discount_percentage')->default(0);
            $table->json('color')->nullable();
            $table->string('file_path');
            $table->string('image_path');
            $table->enum('print_type', PrintTypeEnum::getValues());
            $table->timestamps();
        });

        DB::statement('ALTER TABLE designs ADD CONSTRAINT check_discount_percentage_range CHECK (discount_percentage >= 0 AND discount_percentage <= 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
