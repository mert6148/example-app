<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migrasyonu çalıştır
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();

            // Çeviri anahtarı (örn: 'app.welcome', 'messages.hello')
            $table->string('key', 100);

            // Dil kodu (tr, en, es, fr, de, etc.)
            $table->string('locale', 10)->default('tr');

            // Çeviri metni
            $table->text('value');

            // Grup (app, messages, validation, emails, etc.)
            $table->string('group', 50)->default('app');

            // Kategori (optional)
            $table->string('category', 50)->nullable();

            // Dosya yolu (migrasyonu izlemek için)
            $table->string('file_path')->nullable();

            // Varsayılan dil mi (tr/en)
            $table->boolean('is_default')->default(false);

            // Aktif mi
            $table->boolean('is_active')->default(true);

            // Not (yönetici notları)
            $table->text('notes')->nullable();

            // Context (parametreler, örn: {count}, {name})
            $table->json('parameters')->nullable();

            // Metadata
            $table->json('metadata')->nullable();

            // Zaman damgaları
            $table->timestamps();
            $table->softDeletes();

            // Endeksler
            $table->index('locale');
            $table->index('group');
            $table->index('category');
            $table->index(['locale', 'group']);
            $table->index('is_active');
            $table->unique(['key', 'locale'], 'unique_translation_key_locale');
        });

        // Dil dosyaları (seeding için)
        Schema::create('language_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 100)->unique();
            $table->string('locale', 10);
            $table->string('group', 50);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->index(['locale', 'group']);
        });

        // Çeviri sürümleri (değişiklik takibi)
        Schema::create('translation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_id')->constrained('translations')->onDelete('cascade');
            $table->text('old_value')->nullable();
            $table->text('new_value');
            $table->string('changed_by')->nullable();
            $table->timestamp('changed_at')->useCurrent();

            $table->index('translation_id');
            $table->index('changed_at');
        });
    }

    /**
     * Migrasyonu geri al
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_histories');
        Schema::dropIfExists('language_files');
        Schema::dropIfExists('translations');
    }
};
