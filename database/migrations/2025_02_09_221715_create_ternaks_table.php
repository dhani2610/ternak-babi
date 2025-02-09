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
        Schema::create('ternaks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag_number')->unique();
            $table->string('gender');
            $table->date('date_birthday');
            $table->integer('is_full_breed')->default(0);
            $table->string('breed')->nullable();
            $table->integer('is_breeding_stok')->default(0);
            $table->integer('pig_pen')->nullable();
            $table->text('comment')->nullable();
            $table->string('father_tag')->nullable();
            $table->string('mother_tag')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->string('color')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('purchased_from')->nullable();
            $table->date('date_delivered_to_farm');
            $table->string('purchase_price')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->string('photo3')->nullable();
            $table->string('photo4')->nullable();
            $table->enum('status', ['archive', 'trash', 'active'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternaks');
    }
};
