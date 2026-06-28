<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Motif;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMotifs' => Motif::count(),
            'sacredMotifs' => Motif::where('category', 'sakral')->count(),
            'verifiedMotifs' => Motif::where('verification_status', 'terverifikasi')->count(),
            'pendingMotifs' => Motif::where('verification_status', 'perlu_pendalaman')->count(),
            'recentMotifs' => Motif::latest()->take(5)->get(),
            'recentLogs' => ActivityLog::with('user')->latest()->take(5)->get(),
        ]);
    }
}