<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterFAQ;

class SubscriptionController extends Controller
{
    public function index()
    {
        $faqs = MasterFAQ::query()
            ->orderByRaw('CAST(`order` AS UNSIGNED) ASC')
            ->get();

        return view('user-page.subscription.index', compact('faqs'));
    }
}