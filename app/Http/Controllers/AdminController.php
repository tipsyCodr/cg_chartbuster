<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
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
        $stats = $this->analytics->getStats();
        return response()->json($stats);
    }

    public function userManagement(Request $request)
    {
        $query = User::withCount(['reviews', 'ratings']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $is_active = $request->status === 'Active';
            $query->where('is_active', $is_active);
        }

        $users = $query->latest()->paginate($request->get('per_page', 10))->withQueryString();

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
            'status' => 'required|string|in:Active,Inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => $request->status === 'Active',
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->status === 'Active',
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function exportUsers(Request $request)
    {
        $query = User::query();

        // Apply same filters as userManagement for export
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $is_active = $request->status === 'Active';
            $query->where('is_active', $is_active);
        }

        $users = $query->latest()->get();
        $csvFileName = 'cgchartbusters_users_export_' . date('Y-m-d_H-i-s') . '.csv';

        $columns = ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At', 'Last Login'];

        return response()->streamDownload(function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'User',
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at ? $user->created_at->toDateTimeString() : '',
                    $user->last_login ? $user->last_login->toDateTimeString() : '',
                ]);
            }

            fclose($file);
        }, $csvFileName);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|string|in:delete,activate,deactivate',
        ]);

        $ids = $request->user_ids;
        $action = $request->action;

        switch ($action) {
            case 'delete':
                User::whereIn('id', $ids)->delete();
                $message = 'Selected users deleted successfully.';
                break;
            case 'activate':
                User::whereIn('id', $ids)->update(['is_active' => true]);
                $message = 'Selected users activated successfully.';
                break;
            case 'deactivate':
                User::whereIn('id', $ids)->update(['is_active' => false]);
                $message = 'Selected users deactivated successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
