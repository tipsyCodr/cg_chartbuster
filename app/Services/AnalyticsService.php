<?php

namespace App\Services;

use App\Models\PageView;
use App\Models\User;
use App\Models\Movie;
use App\Models\Song;
use App\Models\Artist;
use App\Models\TvShow;
use App\Models\Review;
use App\Models\Watchlist;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsService
{
    public function getStats()
    {
        return [
            'overview' => $this->getOverviewStats(),
            'visitor_stats' => $this->getVisitorStats(),
            'traffic_trend' => $this->getTrafficTrend(),
            'content_performance' => $this->getContentPerformance(),
            'user_engagement' => $this->getUserEngagementStats(),
            'moderation' => $this->getModerationOverview(),
            'trending' => $this->getTrendingContent(),
        ];
    }

    private function getOverviewStats()
    {
        return [
            'total_users' => User::count(),
            'total_content' => Movie::count() + Song::count() + Artist::count() + TvShow::count(),
            'total_ratings' => Review::whereNotNull('rating')->count(),
            'total_reviews' => Review::whereNotNull('review_text')->count(),
        ];
    }

    private function getVisitorStats()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        return [
            'total_visitors_today' => PageView::whereDate('created_at', $today)->distinct('ip_address')->count(),
            'total_visitors_month' => PageView::where('created_at', '>=', $startOfMonth)->distinct('ip_address')->count(),
            'unique_visitors' => PageView::distinct('ip_address')->count(),
            'total_page_views' => PageView::count(),
            'new_users_month' => User::where('created_at', '>=', $startOfMonth)->count(),
        ];
    }

    private function getTrafficTrend($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);

        return PageView::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    private function getContentPerformance()
    {
        return [
            'top_movies' => Movie::orderByDesc('views')->take(5)->get(['id', 'title', 'views', 'cg_chartbusters_ratings as average_rating']),
            'top_songs' => Song::orderByDesc('views')->take(5)->get(['id', 'title', 'views', 'cg_chartbusters_ratings as average_rating']),
            'top_artists' => Artist::orderByDesc('views')->take(5)->get(['id', 'name as title', 'views', 'cgcb_rating as average_rating']),
            
            'most_rated_movies' => Movie::withCount('reviews')
                ->orderByDesc('reviews_count')
                ->take(5)
                ->get(['id', 'title', 'reviews_count', 'cg_chartbusters_ratings as average_rating']),
            
            'highest_rated_movies' => Movie::orderByDesc('cg_chartbusters_ratings')
                ->where('cg_chartbusters_ratings', '>', 0)
                ->take(5)
                ->get(['id', 'title', 'cg_chartbusters_ratings as average_rating']),
        ];
    }

    private function getUserEngagementStats()
    {
        $dailyRatings = Review::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereNotNull('rating')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();

        return [
            'total_watchlist_adds' => Watchlist::count(),
            'most_active_users' => User::withCount('reviews')
                ->orderByDesc('reviews_count')
                ->take(5)
                ->get(['id', 'name', 'reviews_count']),
            'daily_ratings' => $dailyRatings,
        ];
    }

    private function getModerationOverview()
    {
        return [
            'pending_reviews_count' => Review::where('flagged', '>', 0)->count(),
            'pending_reports_count' => Report::where('status', 'pending')->count(),
            
            'flagged_reviews' => Review::with(['user', 'movie', 'song', 'tvshow', 'artist'])
                ->where('flagged', '>', 0)
                ->where('removed', 0)
                ->latest()
                ->take(10)
                ->get(),
                
            'pending_reports' => Report::with(['reportable'])
                ->where('status', 'pending')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($report) {
                    $report->reporter_name = User::find($report->user_id)?->name ?? 'Anonymous';
                    return $report;
                }),
                
            'recent_added' => Movie::latest('created_at')->take(5)->get(['id', 'title', 'created_at']),
        ];
    }

    private function getTrendingContent($days = 7)
    {
        $startDate = \Carbon\Carbon::now()->subDays($days);

        $trending = PageView::selectRaw('page_type, content_id, COUNT(*) as view_count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('page_type', 'content_id')
            ->orderByDesc('view_count')
            ->take(10)
            ->get();

        return $trending->map(function ($track) {
            $modelClass = match ($track->page_type) {
                'movie' => \App\Models\Movie::class,
                'song' => \App\Models\Song::class,
                'artist' => \App\Models\Artist::class,
                'tvshow' => \App\Models\TvShow::class,
                default => null,
            };

            if (!$modelClass) return null;
            
            $model = $modelClass::find($track->content_id);
            if (!$model) return null;

            return [
                'id' => $track->content_id,
                'title' => $model->title ?? $model->name ?? 'Unknown',
                'type' => ucfirst($track->page_type),
                'views' => $track->view_count,
            ];
        })->filter()->values();
    }
}
