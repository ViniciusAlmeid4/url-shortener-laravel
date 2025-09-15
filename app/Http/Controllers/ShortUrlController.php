<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ShortUrlController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $urls = $request->user()->shortUrls;
        return view('home', ['urls' => $urls]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'urlInput' => ['required', 'url', 'max:2048'],
            'password' => ['max:30']
        ]);

        $newUrl = $request->user()->shortUrls()->create([
            'original' => $validated['urlInput'],
            'password_hash' => hash::make($validated['password']),
            'code' => Str::random(10)
        ]);

        return response()->json([
            'message' => 'New url created with code: ' . $newUrl->code,
            'id' => $newUrl->id,
            'shortened' => $newUrl->shortened,
            'original' => $newUrl->original,
            'created_at' => $newUrl->created_at->format('d/m/Y H:i'),
            'code' => $newUrl->code
        ], 201);
    }

    public function showByCode(Request $request, string $code) {
        $url = ShortUrl::where('code', $code)
            ->where('is_active', true)
            ->when(now(), fn($q, $now) => $q->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            }))
            ->firstOrFail();

        if (empty($url->password_hash) || (Auth::check() && Auth::id() == $url->user_id)) {
            dd([$url->password_hash, Auth::check(), Auth::id(), $url->user_id]);
            $url->increment('clicks');
            return redirect()->away($url->original, 301);
        } else {
            return view('urlWithPassword', ['url' => $url]); //
        }
    }

    public function checkWithPassword(Request $request, string $code) {
        $url = ShortUrl::where('code', $code)
            ->where('is_active', true)
            ->when(now(), fn($q, $now) => $q->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            }))
            ->firstOrFail();

        if (Hash::check($request->password, $url->password_hash)) {
            return redirect()->away($url->original, 301);
        } else {
            return back()->withErrors(['password' => 'Wrong password!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $code) {
        if (!$request->user()->id) {
            view('login', ['error' => 'Please, login first!']);
        }

        $url = ShortUrl::where('code', $code)->firstOrFail();
        if ($url->user_id === $request->user()->id) {
            $url->delete();
            return response()->json([
                'message' => "Everything cleaned up.",
            ], 200);
        } else {
            return response()->json([
                'message' => "Don't try excluding what's not your's!",
            ], 403);
        }
    }
}
