<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tamus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->string('telepon', 12);
            $table->text('instansi')->nullable();
            $table->foreignId('id_staf');
            $table->boolean('is_janji');
            $table->timestamp('tgl_kunjungan');
            $table->text('keperluan');
            $table->text('informasi')->nullable();
            $table->boolean('status')->default(false);
            $table->string('survey_token')->nullable();
            $table->tinyInteger('reaction')->nullable();
            $table->timestamp('reaction_submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tamus');
    }
};
