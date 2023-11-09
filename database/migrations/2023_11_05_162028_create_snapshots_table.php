<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('snapshots')) {
            Schema::create('snapshots', function (Blueprint $table) {
                $table->id();
                $table->uuid('aggregate_uuid');
                $table->unsignedInteger('aggregate_version');
                $table->jsonb('state');

                $table->timestamps();

                $table->index('aggregate_uuid');
            });
        }
    }
};
