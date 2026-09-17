<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const PROFILE_TABLES = [
        'securities',
        'companies',
        'b_u_j_p_s',
    ];

    public function up(): void
    {
        foreach (self::PROFILE_TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->char('province_code', 2)->nullable()->after('province');
                $table->char('city_code', 4)->nullable()->after('city');
                $table->char('district_code', 7)->nullable()->after('district');
                $table->char('village_code', 10)->nullable()->after('village');

                $table->index(
                    ['province_code', 'city_code', 'district_code', 'village_code'],
                    $tableName.'_location_codes_index'
                );
            });
        }
    }

    public function down(): void
    {
        foreach (self::PROFILE_TABLES as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName): void {
                $table->dropIndex($tableName.'_location_codes_index');
                $table->dropColumn([
                    'province_code',
                    'city_code',
                    'district_code',
                    'village_code',
                ]);
            });
        }
    }
};
