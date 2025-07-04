<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlToAuditHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('audit_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('audit_histories', 'url')) {
                $table->string('url')->after('user_id'); // Tambahkan kolom url
            }
        });
    }

    public function down()
    {
        Schema::table('audit_histories', function (Blueprint $table) {
            if (Schema::hasColumn('audit_histories', 'url')) {
                $table->dropColumn('url'); // Hapus kolom saat rollback
            }
        });
    }
}
