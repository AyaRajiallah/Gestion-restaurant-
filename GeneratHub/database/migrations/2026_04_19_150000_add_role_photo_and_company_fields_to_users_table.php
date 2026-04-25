<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('account_type');
            $table->string('profile_photo_path')->nullable()->after('role');
            $table->string('company_city')->nullable()->after('organization_name');
            $table->string('company_size')->nullable()->after('company_city');
            $table->string('website')->nullable()->after('company_size');
            $table->text('target_profiles')->nullable()->after('website');
        });

        DB::table('users')
            ->where('email', 'ayarajiallah@gmail.com')
            ->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'profile_photo_path',
                'company_city',
                'company_size',
                'website',
                'target_profiles',
            ]);
        });
    }
};
