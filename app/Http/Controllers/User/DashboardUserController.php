<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\BUJP;
use Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'company')
        {
            $data['profile'] = Company::find(Auth::user()->user_company->company->id);
        } elseif(Auth::user()->role == 'bujp') {
            $data['profile'] = BUJP::find(Auth::user()->user_bujp->bujp->id);
        } else {
            return redirect()->route('login');
        }

        $data['profile_progress'] = $data['profile']->profileProgress();

        return view('dashboard-user.index', $data);
    }
}
