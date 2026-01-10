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
        Schema::create('top_bar_messages', function (Blueprint $table) {
            $table->id();

            // Título interno (opcional)
            $table->string('title')->nullable();

            // Contenido HTML desde tu editor (WYSIWYG)
            $table->longText('content_html');

            // Programación
            $table->timestamp('starts_at')->nullable(); // si es null, puede iniciar ya
            $table->timestamp('ends_at')->nullable();   // si es null, no expira

            // Control
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('priority')->default(0); // orden/precedencia

            $table->timestamps();

            $table->index(['is_active', 'starts_at', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_bar_messages');
    }
};
