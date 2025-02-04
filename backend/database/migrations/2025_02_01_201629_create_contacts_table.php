<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Внешний ключ (кто добавил)
            $table->foreignId('contact_id')->constrained('users')->onDelete('cascade'); // Внешний ключ (кого добавили)
            $table->string('nickname')->nullable(); // Псевдоним (необязательный)
            $table->timestamps();

            // Уникальный индекс, чтобы один пользователь не мог добавить другого дважды
            $table->unique(['user_id', 'contact_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};