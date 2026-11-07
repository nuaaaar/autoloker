<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenSetting;
use Illuminate\Http\Request;

class TokenSettingController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        return view('dashboard-admin.token-settings.index', [
            'settings' => TokenSetting::current(),
        ]);
    }

    public function update(Request $request)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $data = $request->validate([
            'idr_per_token' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'job_post_tokens' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'job_post_days' => ['required', 'integer', 'min:1', 'max:365000'],
            'training_post_tokens' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'training_post_days' => ['required', 'integer', 'min:1', 'max:365000'],
        ]);

        $settings = TokenSetting::current();
        $settings->fill($data)->save();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'settings' => $settings,
            ]);
        }

        return back()->with('success', 'Pengaturan token berhasil diperbarui.');
    }
}
