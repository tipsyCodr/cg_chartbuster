<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function dashboard()
    {
        $stats = [
            'totalUsers' => \App\Models\User::count(),
            'totalMovies' => \App\Models\Movie::count(),
            'totalSongs' => \App\Models\Song::count(),
            'totalTvShows' => \App\Models\TvShow::count(),
            'totalArtists' => \App\Models\Artist::count(),
            'totalReviews' => \App\Models\Review::count(),
            'recentReviews' => \App\Models\Review::with(['user', 'movie', 'song', 'artist', 'tvshow'])->latest()->take(5)->get(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function stats()
    {
        $dailyRatings = \App\Models\Review::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereNotNull('rating')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();

        return response()->json([
            'total_users' => \App\Models\User::count(),
            'total_ratings' => \App\Models\Review::whereNotNull('rating')->count(),
            'total_reviews' => \App\Models\Review::whereNotNull('review_text')->count(),
            'pending_reviews' => \App\Models\Review::where('flagged', '>', 0)->count(),
            'total_content' => \App\Models\Movie::count() + \App\Models\Song::count() + \App\Models\Artist::count() + \App\Models\TvShow::count(),

            'top_movies' => \App\Models\Movie::orderByDesc('views')->take(5)->get(['id', 'title', 'views', 'cg_chartbusters_ratings as average_rating']),
            'top_songs' => \App\Models\Song::orderByDesc('views')->take(5)->get(['id', 'title', 'views', 'cg_chartbusters_ratings as average_rating']),
            'top_artists' => \App\Models\Artist::orderByDesc('views')->take(5)->get(['id', 'name as title', 'views', 'cgcb_rating as average_rating']),

            'pending_reports' => \App\Models\Report::where('status', 'pending')->count(),
            'recent_added' => \App\Models\Movie::latest('created_at')->take(5)->get(['id', 'title', 'created_at']),
            
            'daily_ratings' => $dailyRatings,
        ]);
    }

    public function userManagement()
    {
        $users = User::all();
        return view('admin.user-management', compact('users'));
    }

    public function toggleUserStatus(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function exportUsers()
    {
        $users = User::all();
        $csvFileName = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'User',
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
