<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MasterBank;
use App\Models\TokenSetting;
use App\Models\TokenTransaction;
use App\Models\UserOrderManual;
use App\Services\TokenBillingService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request, TokenBillingService $billing)
    {
        $owner = $billing->ownerFor($request->user());
        $wallet = $billing->walletFor($owner);

        return view('dashboard-user.tokens.index', [
            'settings' => TokenSetting::current(),
            'wallet' => $wallet,
            'orders' => UserOrderManual::where('token_wallet_id', $wallet->id)->latest('id')->paginate(10, ['*'], 'orders_page'),
            'transactions' => TokenTransaction::where('token_wallet_id', $wallet->id)->latest('id')->paginate(10, ['*'], 'transactions_page'),
            'banks' => MasterBank::orderBy('bank_name')->get(),
        ]);
    }
}
