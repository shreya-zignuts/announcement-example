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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->date('date');
            $table->time('time');
            $table
                ->enum('status', ['V', 'N'])
                ->default('N')
                ->comment('V: Visible, V: Not Visible');
            $table->timestamps();
            $table
                ->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table
                ->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
