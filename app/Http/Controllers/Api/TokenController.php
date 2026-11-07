<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TokenSetting;
use App\Models\TokenTransaction;
use App\Services\TokenBillingService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show(Request $request, TokenBillingService $billing)
    {
        $owner = $billing->ownerFor($request->user());
        $wallet = $billing->walletFor($owner);
        $transactions = TokenTransaction::where('token_wallet_id', $wallet->id)->latest('id')->paginate(20);

        return response()->json(['status' => true, 'data' => [
            'settings' => TokenSetting::current()->only(['idr_per_token', 'job_post_tokens', 'job_post_days', 'training_post_tokens', 'training_post_days']),
            'wallet' => ['balance' => (int) $wallet->balance],
            'transactions' => $transactions->items(),
            'pagination' => ['current_page' => $transactions->currentPage(), 'last_page' => $transactions->lastPage(), 'per_page' => $transactions->perPage(), 'total' => $transactions->total()],
        ]]);
    }
}
