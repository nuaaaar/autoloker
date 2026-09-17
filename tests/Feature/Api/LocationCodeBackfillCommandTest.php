<?php

namespace Tests\Feature\Api;

use App\Models\Security;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LocationCodeBackfillCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_backfills_hierarchical_location_codes(): void
    {
        $timestamp = now();

        DB::table('indonesia_provinces')->insert([
            'code' => '11',
            'name' => 'Aceh',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_cities')->insert([
            'code' => '1101',
            'province_code' => '11',
            'name' => 'Banda Aceh',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_districts')->insert([
            'code' => '110101',
            'city_code' => '1101',
            'name' => 'Baiturrahman',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
        DB::table('indonesia_villages')->insert([
            'code' => '1101012001',
            'district_code' => '110101',
            'name' => 'Ateuk Pahlawan',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        $profile = Security::create([
            'province' => ' aceh ',
            'city' => 'BANDA ACEH',
            'district' => 'Baiturrahman',
            'village' => 'Ateuk Pahlawan',
        ]);

        $this->artisan('profiles:backfill-location-codes', [
            '--table' => 'securities',
            '--chunk' => 1,
        ])
            ->expectsOutput('securities: 1 profiles processed')
            ->assertExitCode(0);

        $this->assertDatabaseHas('securities', [
            'id' => $profile->id,
            'province_code' => '11',
            'city_code' => '1101',
            'district_code' => '110101',
            'village_code' => '1101012001',
        ]);
    }
}
