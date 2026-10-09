<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class OwnedOrganizationController extends Controller
{
    /**
     * Resolve the authenticated company profile and its foreign key column.
     *
     * @return array{column: string, id: int}
     */
    protected function owner(Request $request): array
    {
        $user = $request->user();

        if ($user?->role !== 'company' || ! $user->user_company?->company) {
            throw new NotFoundHttpException('Profil perusahaan tidak ditemukan.');
        }

        return [
            'column' => 'company_id',
            'id' => $user->user_company->company->id,
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
