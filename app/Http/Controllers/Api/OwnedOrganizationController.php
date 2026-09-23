<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class OwnedOrganizationController extends Controller
{
    /**
     * Resolve the authenticated company or BUJP profile and its foreign key.
     *
     * @return array{column: string, id: int}
     */
    protected function owner(Request $request): array
    {
        $user = $request->user();

        $owner = match ($user?->role) {
            'bujp' => [
                'column' => 'b_u_j_p_id',
                'profile' => $user->user_bujp?->bujp,
            ],
            'company' => [
                'column' => 'company_id',
                'profile' => $user->user_company?->company,
            ],
            default => null,
        };

        if (! $owner || ! $owner['profile']) {
            throw new NotFoundHttpException('Company or BUJP profile not found.');
        }

        return [
            'column' => $owner['column'],
            'id' => $owner['profile']->id,
        ];
    }

    protected function pagination(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'has_more' => $paginator->hasMorePages(),
            'next_page_url' => $paginator->nextPageUrl(),
            'previous_page_url' => $paginator->previousPageUrl(),
        ];
    }
}
