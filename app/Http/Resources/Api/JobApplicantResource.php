<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\SecurityProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'job_vacancy_id' => $this->job_vacancy_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'security' => $this->whenLoaded('security', function (): ?array {
                $security = $this->getRelation('security');

                return $security
                    ? (new SecurityProfileResource($security))->resolve()
                    : null;
            }),
        ];
    }
}
