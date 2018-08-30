<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image']
        ]);
    }
}
