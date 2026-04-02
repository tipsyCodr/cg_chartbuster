@extends('layouts.admin')

@section('page-title', 'Analytics & Moderation Dashboard')

@section('content')
<div x-data="dashboardAnalytics()" x-init="fetchStats()" class="space-y-6">

    <!-- Loading State -->
    <div x-show="loading" class="flex justify-center items-center py-20">
        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-xl text-gray-600">Syncing real-time platform data...</span>
    </div>

    <div x-show="!loading" x-cloak class="space-y-8 pb-10">

        <!-- 1. Key Performance Indicators (KPIs) -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Platform KPIs</h2>
                <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded">Updated just now</span>
            </div>
            
            <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-4">
                <!-- Group 1: Users & Traffic -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Visitors</h3>
                        <div class="bg-blue-50 p-2 rounded-lg text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition"><i class="fas fa-eye"></i></div>
                    </div>
                    <p class="text-3xl font-black text-gray-800" x-text="stats.visitor_stats?.total_page_views || 0"></p>
                    <div class="mt-2 text-xs text-gray-500">
                        <span class="text-blue-600 font-bold" x-text="'+' + (stats.visitor_stats?.total_visitors_today || 0)"></span> today
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Unique Visitors</h3>
                        <div class="bg-indigo-50 p-2 rounded-lg text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition"><i class="fas fa-fingerprint"></i></div>
                    </div>
                    <p class="text-3xl font-black text-gray-800" x-text="stats.visitor_stats?.unique_visitors || 0"></p>
                    <div class="mt-2 text-xs text-gray-500">
                        <span class="text-indigo-600 font-bold" x-text="stats.visitor_stats?.total_visitors_month || 0"></span> this month
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Users</h3>
                        <div class="bg-emerald-50 p-2 rounded-lg text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition"><i class="fas fa-users"></i></div>
                    </div>
                    <p class="text-3xl font-black text-gray-800" x-text="stats.overview?.total_users || 0"></p>
                    <div class="mt-2 text-xs text-gray-500">
                        <span class="text-emerald-600 font-bold" x-text="'+' + (stats.visitor_stats?.new_users_month || 0)"></span> new this month
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">User Engagement</h3>
                        <div class="bg-amber-50 p-2 rounded-lg text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition"><i class="fas fa-heart"></i></div>
                    </div>
                    <p class="text-3xl font-black text-gray-800" x-text="stats.user_engagement?.total_watchlist_adds || 0"></p>
                    <div class="mt-2 text-xs text-gray-500 uppercase font-semibold">Watchlist Adds</div>
                </div>
            </div>
        </section>

        <!-- 2. Charts & Trends -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-700">Traffic Trend (Last 30 Days)</h3>
                    <div class="flex space-x-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        <span class="text-xs text-gray-500">Page Views</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="trafficTrendChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-700">Daily Rating Activity</h3>
                    <div class="flex space-x-2">
                        <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                        <span class="text-xs text-gray-500">Ratings</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="ratingsChart"></canvas>
                </div>
            </div>
        </section>

        <!-- 3. Trending Content (Last 7 Days) -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Trending Content (Last 7 Days)</h2>
                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-bold uppercase">Popular Now</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                <template x-for="item in stats.trending" :key="item.type + item.id">
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-100 transition">
                            <i class="fas fa-fire text-orange-500 text-xs"></i>
                        </div>
                        <div class="text-[10px] font-bold text-blue-500 uppercase mb-1" x-text="item.type"></div>
                        <h4 class="text-sm font-black text-gray-800 line-clamp-2 mb-3 leading-tight" x-text="item.title"></h4>
                        <div class="mt-auto pt-2 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-[10px] text-gray-400 font-medium">
                                <i class="fas fa-chart-line mr-1 text-blue-400"></i>
                                <span x-text="item.views.toLocaleString()"></span> views
                            </span>
                            <div class="w-10 h-1 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500" :style="`width: ${Math.min((item.views / stats.trending[0]?.views) * 100, 100)}%`"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="!stats.trending?.length" class="bg-white p-10 rounded-xl border border-dashed border-gray-200 text-center text-gray-400 text-sm">
                Insufficient data to calculate trends for the last 7 days.
            </div>
        </section>

        <!-- 4. Moderation Queue -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Moderation Queue</h2>
                <div class="flex space-x-4">
                    <div class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                        <span x-text="stats.moderation?.pending_reports_count"></span> Reports
                    </div>
                    <div class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">
                        <span x-text="stats.moderation?.pending_reviews_count"></span> Flagged
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Flagged Reviews -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Flagged Reviews</h3>
                    </div>
                    <div class="overflow-y-auto max-h-[400px]">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-widest border-b">
                                    <th class="px-6 py-3">Reviewer / Content</th>
                                    <th class="px-6 py-3">Review Text</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="review in stats.moderation?.flagged_reviews" :key="review.id">
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-gray-800" x-text="review.user?.name || 'Anonymous'"></div>
                                            <div class="text-[10px] text-blue-600 font-medium mt-0.5" 
                                                 x-text="(review.movie?.title || review.song?.title || review.artist?.name || review.tvshow?.title)"></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-xs text-gray-600 line-clamp-2 italic" x-text="review.review_text"></p>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button @click="moderateReview(review.id, 'approve')" class="p-1 px-2 text-emerald-600 hover:bg-emerald-50 rounded text-[10px] font-bold border border-emerald-100">Approve</button>
                                                <button @click="moderateReview(review.id, 'reject')" class="p-1 px-2 text-red-600 hover:bg-red-50 rounded text-[10px] font-bold border border-red-100">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div x-show="!stats.moderation?.flagged_reviews?.length" class="p-10 text-center text-gray-400 text-sm">
                            Queue empty. All reviews cleared!
                        </div>
                    </div>
                </div>

                <!-- Pending Reports -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Content Reports</h3>
                    </div>
                    <div class="overflow-y-auto max-h-[400px]">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-widest border-b">
                                    <th class="px-6 py-3">Reporter</th>
                                    <th class="px-6 py-3">Entity / Reason</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="report in stats.moderation?.pending_reports" :key="report.id">
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-gray-800" x-text="report.reporter_name"></div>
                                            <div class="text-[9px] text-gray-400" x-text="new Date(report.created_at).toLocaleDateString()"></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-black text-gray-700 uppercase" x-text="report.reportable_type.split('\\').pop()"></div>
                                            <p class="text-[10px] text-gray-500 mt-1" x-text="report.reason"></p>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <button @click="resolveReport(report.id, 'resolved')" class="p-1 px-2 bg-blue-600 text-white rounded text-[10px] font-bold">Resolve</button>
                                                <button @click="resolveReport(report.id, 'rejected')" class="p-1 px-2 text-gray-500 hover:bg-gray-100 rounded text-[10px] font-bold">Dismiss</button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div x-show="!stats.moderation?.pending_reports?.length" class="p-10 text-center text-gray-400 text-sm">
                            No active content reports.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Content Performance -->
        <section>
            <h2 class="text-xl font-bold mb-4 text-gray-800">Top Performing Content</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Most Viewed Movies -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-700 text-sm">Top Viewed Movies</h3>
                        <i class="fas fa-video text-gray-400"></i>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.content_performance?.top_movies" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                                <div class="truncate mr-2">
                                    <p class="font-semibold text-sm text-gray-800 truncate" x-text="item.title"></p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400 text-[10px]">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star" :class="i <= Math.round(item.average_rating) ? 'text-amber-400' : 'text-gray-200'"></i>
                                            </template>
                                        </div>
                                        <span class="text-[10px] text-gray-400 ml-2" x-text="parseFloat(item.average_rating).toFixed(1)"></span>
                                    </div>
                                </div>
                                <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-md whitespace-nowrap" x-text="item.views.toLocaleString() + ' views'"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Most Viewed Songs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-700 text-sm">Top Viewed Songs</h3>
                        <i class="fas fa-music text-gray-400"></i>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.content_performance?.top_songs" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                                <div class="truncate mr-2">
                                    <p class="font-semibold text-sm text-gray-800 truncate" x-text="item.title"></p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-amber-400 text-[10px]">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star" :class="i <= Math.round(item.average_rating) ? 'text-amber-400' : 'text-gray-200'"></i>
                                            </template>
                                        </div>
                                        <span class="text-[10px] text-gray-400 ml-2" x-text="parseFloat(item.average_rating).toFixed(1)"></span>
                                    </div>
                                </div>
                                <span class="bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-1 rounded-md whitespace-nowrap" x-text="item.views.toLocaleString() + ' views'"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Highest Rated Movies -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                        <h3 class="font-bold text-gray-700 text-sm">Highest Rated Movies</h3>
                        <i class="fas fa-trophy text-gray-400"></i>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.content_performance?.highest_rated_movies" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                                <div class="truncate mr-2">
                                    <p class="font-semibold text-sm text-gray-800 truncate" x-text="item.title"></p>
                                    <p class="text-[10px] text-gray-400">Average Rating</p>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-amber-600 text-sm font-black" x-text="parseFloat(item.average_rating).toFixed(1)"></span>
                                    <div class="flex text-amber-400 text-[8px]">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 6. User Activity Dashboard -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 bg-white p-6 rounded-xl border border-gray-100">
                <h3 class="font-bold text-gray-700 text-sm mb-4">Most Active Users</h3>
                <ul class="space-y-3">
                    <template x-for="user in stats.user_engagement?.most_active_users" :key="user.id">
                        <li class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 mr-2" x-text="user.name.charAt(0)"></div>
                                <span class="text-xs font-semibold text-gray-700" x-text="user.name"></span>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400" x-text="user.reviews_count + ' reviews'"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Recently Added Media</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-widest">
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Added Date</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="item in stats.moderation?.recent_added" :key="item.id">
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-800" x-text="item.title"></div>
                                        <div class="text-[10px] text-gray-400">ID: #<span x-text="item.id"></span></div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500" x-text="new Date(item.created_at).toLocaleDateString()"></td>
                                    <td class="px-6 py-4"><span class="text-[10px] font-bold px-2 py-0.5 rounded bg-gray-100 text-gray-600">Movie</span></td>
                                    <td class="px-6 py-4 text-right cursor-not-allowed opacity-50">
                                        <div class="flex justify-end space-x-2">
                                            <button class="p-1.5 text-gray-400"><i class="fas fa-edit text-xs"></i></button>
                                            <button class="p-1.5 text-gray-400"><i class="fas fa-trash-alt text-xs"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardAnalytics', () => ({
            stats: {},
            loading: true,
            trafficChart: null,
            ratingsChart: null,

            get csrfToken() {
                return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },

            async fetchStats() {
                try {
                    const response = await fetch('/api/admin/stats');
                    if (!response.ok) throw new Error('API Error');
                    this.stats = await response.json();
                    this.loading = false;
                    
                    this.$nextTick(() => {
                        this.renderTrafficChart();
                        this.renderRatingsChart();
                    });

                } catch (error) {
                    console.error("Failed to fetch dashboard stats", error);
                }
            },

            async moderateReview(id, action) {
                if(!confirm(`Are you sure you want to ${action} this review?`)) return;
                
                try {
                    const response = await fetch(`/admin/moderation/review/${id}/${action}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        this.stats.moderation.flagged_reviews = this.stats.moderation.flagged_reviews.filter(r => r.id !== id);
                        this.stats.moderation.pending_reviews_count--;
                    }
                } catch (error) {
                    console.error("Moderation failed", error);
                }
            },

            async resolveReport(id, status) {
                if(!confirm(`Mark this report as ${status}?`)) return;
                
                try {
                    const response = await fetch(`/admin/moderation/report/${id}/status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: status })
                    });
                    const result = await response.json();
                    if (result.success) {
                        this.stats.moderation.pending_reports = this.stats.moderation.pending_reports.filter(r => r.id !== id);
                        this.stats.moderation.pending_reports_count--;
                    }
                } catch (error) {
                    console.error("Report resolution failed", error);
                }
            },

            renderTrafficChart() {
                const ctx = document.getElementById('trafficTrendChart');
                if (!ctx) return;

                const trafficData = this.stats.traffic_trend || [];
                const labels = trafficData.map(item => new Date(item.date).toLocaleDateString(undefined, {month:'short', day:'numeric'}));
                const dataCounts = trafficData.map(item => item.count);

                if(this.trafficChart) this.trafficChart.destroy();

                this.trafficChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Views',
                            data: dataCounts,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#3b82f6',
                            tension: 0.35,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 10 } } },
                            x: { grid: { display: false }, ticks: { font: { size: 10 }, maxRotation: 45 } }
                        }
                    }
                });
            },

            renderRatingsChart() {
                const ctx = document.getElementById('ratingsChart');
                if (!ctx) return;

                const dailyData = [...(this.stats.user_engagement?.daily_ratings || [])].reverse();
                const labels = dailyData.map(item => new Date(item.date).toLocaleDateString(undefined, {month:'short', day:'numeric'}));
                const dataCounts = dailyData.map(item => item.count);

                if(this.ratingsChart) this.ratingsChart.destroy();

                this.ratingsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ratings',
                            data: dataCounts,
                            backgroundColor: 'rgba(168, 85, 247, 0.8)',
                            borderRadius: 6,
                            barThickness: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 10 } } },
                            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                        }
                    }
                });
            }
        }));
    });
</script>
@endsection
