<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('audit_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi dengan user
            $table->string('url'); // Pastikan kolom url ini di-set sebagai string dan tidak boleh kosong
            $table->integer('seo_score'); // Skor SEO
            $table->timestamps(); // created_at dan updated_at

            // Menambahkan foreign key untuk relasi dengan tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_histories');
    }
}
