<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('account_type');
            $table->string('attachment_label')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('attachment_label');
            $table->string('diploma')->nullable()->after('birth_date');
            $table->string('graduation_year')->nullable()->after('diploma');
            $table->string('field_of_study')->nullable()->after('graduation_year');
            $table->string('graduation_city')->nullable()->after('field_of_study');
            $table->string('organization_name')->nullable()->after('graduation_city');
            $table->string('sector')->nullable()->after('organization_name');
            $table->text('goal')->nullable()->after('sector');
            $table->string('application_stage')->default('profile_created')->after('goal');
            $table->boolean('terms_accepted')->default(false)->after('application_stage');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone',
                'attachment_label',
                'birth_date',
                'diploma',
                'graduation_year',
                'field_of_study',
                'graduation_city',
                'organization_name',
                'sector',
                'goal',
                'application_stage',
                'terms_accepted',
            ]);
        });
    }
};
