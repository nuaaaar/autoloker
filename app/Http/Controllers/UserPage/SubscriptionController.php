<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterFAQ;
use App\Models\MasterSubscription;
use App\Models\UserSubscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ROLE MAPPING
        |--------------------------------------------------------------------------
        */

        $roleMapping = [
            'satpam' => 'security',
            'bujp' => 'bujp',
            'perusahaan' => 'client',
        ];

        $userRole = strtolower(trim($user->role));

        $role = $roleMapping[$userRole] ?? null;


        /*
        |--------------------------------------------------------------------------
        | MASTER SUBSCRIPTIONS
        |--------------------------------------------------------------------------
        */

        $subscriptions = collect();

        if ($role) {

            $subscriptions = MasterSubscription::query()
                ->where('role', $role)
                ->where('is_active', 1)
                ->orderByRaw("
                    CASE
                        WHEN slug = 'dasar' THEN 0
                        ELSE 1
                    END
                ")
                ->orderBy('sort_order', 'asc')
                ->orderBy('price', 'asc')
                ->get();

        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        $currentSubscription = null;

        if ($role) {

            $currentSubscription = UserSubscription::query()
                ->with('subscription')
                ->where('user_id', $user->id)
                ->where('role', $role)
                ->where('status', 'active')
                ->whereNotNull('expired_at')
                ->where('expired_at', '>', now())
                ->orderByDesc('expired_at')
                ->first();

        }


        /*
        |--------------------------------------------------------------------------
        | FAQ
        |--------------------------------------------------------------------------
        */

        $faqs = MasterFAQ::query()
            ->orderByRaw('CAST(`order` AS UNSIGNED) ASC')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'user-page.subscription.index',
            compact(
                'subscriptions',
                'currentSubscription',
                'faqs'
            )
        );
    }
}