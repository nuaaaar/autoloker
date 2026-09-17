<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LocationCodeBackfillService
{
    private const PROFILE_TABLES = [
        'securities',
        'companies',
        'b_u_j_p_s',
    ];

    /**
     * Backfill location codes from the stored location names.
     *
     * @return array<string, int> Number of processed profiles per table.
     */
    public function backfill(?string $tableName = null, int $chunkSize = 500): array
    {
        if ($chunkSize < 1) {
            throw new InvalidArgumentException('The chunk size must be greater than zero.');
        }

        $tables = $tableName === null
            ? self::PROFILE_TABLES
            : [$this->profileTable($tableName)];
        $maps = $this->locationMaps();
        $processed = [];

        foreach ($tables as $table) {
            $processed[$table] = 0;

            DB::table($table)
                ->select('id', 'province', 'city', 'district', 'village')
                ->orderBy('id')
                ->chunkById($chunkSize, function ($profiles) use ($table, $maps, &$processed): void {
                    foreach ($profiles as $profile) {
                        $provinceCode = $this->lookup($maps['province'], null, $profile->province);
                        $cityCode = $this->lookup($maps['city'], $provinceCode, $profile->city);
                        $districtCode = $this->lookup($maps['district'], $cityCode, $profile->district);
                        $villageCode = $this->lookup($maps['village'], $districtCode, $profile->village);

                        DB::table($table)
                            ->where('id', $profile->id)
                            ->update([
                                'province_code' => $provinceCode,
                                'city_code' => $cityCode,
                                'district_code' => $districtCode,
                                'village_code' => $villageCode,
                            ]);

                        $processed[$table]++;
                    }
                });
        }

        return $processed;
    }

    private function locationMaps(): array
    {
        $prefix = config('laravolt.indonesia.table_prefix', 'indonesia_');

        return [
            'province' => $this->rootLocationMap($prefix.'provinces'),
            'city' => $this->childLocationMap($prefix.'cities', 'province_code'),
            'district' => $this->childLocationMap($prefix.'districts', 'city_code'),
            'village' => $this->childLocationMap($prefix.'villages', 'district_code'),
        ];
    }

    private function profileTable(string $tableName): string
    {
        if (! in_array($tableName, self::PROFILE_TABLES, true)) {
            throw new InvalidArgumentException(sprintf('Unsupported profile table [%s].', $tableName));
        }

        return $tableName;
    }

    private function rootLocationMap(string $tableName): array
    {
        $map = [];

        foreach (DB::table($tableName)->get(['code', 'name']) as $location) {
            $map['name:'.$this->normalize($location->name)] = $location->code;
            $map['code:'.$location->code] = $location->code;
        }

        return $map;
    }

    private function childLocationMap(string $tableName, string $parentColumn): array
    {
        $map = [];

        foreach (DB::table($tableName)->get(['code', 'name', $parentColumn]) as $location) {
            $parentCode = (string) $location->{$parentColumn};
            $map[$parentCode]['name:'.$this->normalize($location->name)] = $location->code;
            $map[$parentCode]['code:'.$location->code] = $location->code;
        }

        return $map;
    }

    private function lookup(array $map, ?string $parentCode, mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        $keys = [
            'name:'.$this->normalize($value),
            'code:'.trim((string) $value),
        ];

        if ($parentCode === null) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $map)) {
                    return $map[$key];
                }
            }

            return null;
        }

        foreach ($keys as $key) {
            if (array_key_exists($key, $map[$parentCode] ?? [])) {
                return $map[$parentCode][$key];
            }
        }

        return null;
    }

    private function normalize(mixed $value): string
    {
        return strtolower(trim((string) $value));
    }
}
