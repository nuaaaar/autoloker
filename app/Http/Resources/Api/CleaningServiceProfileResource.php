<?php

namespace App\Http\Resources\Api;

use App\Services\Api\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CleaningServiceProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return app(ProfileService::class)->showCleaning($this->resource);
    }
}
