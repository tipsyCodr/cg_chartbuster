@extends('layouts.admin')

@section('page-title', 'Platform Analytics Dashboard')

@section('content')
<div x-data="dashboardAnalytics()" x-init="fetchStats()" class="space-y-6">

    <!-- Loading State -->
    <div x-show="loading" class="flex justify-center items-center py-20">
        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-xl text-gray-600">Loading Dashboard Data...</span>
    </div>

    <div x-show="!loading" x-cloak class="space-y-6">

        <!-- 1. Platform Analytics -->
        <section>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Platform Overview</h2>
            <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 sm:p-6 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Users</h3>
                        <p class="text-2xl font-bold text-gray-800" x-text="stats.total_users"></p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full text-blue-600"><i class="fas fa-users text-xl"></i></div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 sm:p-6 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Content</h3>
                        <p class="text-2xl font-bold text-gray-800" x-text="stats.total_content"></p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full text-green-600"><i class="fas fa-film text-xl"></i></div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 sm:p-6 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Ratings</h3>
                        <p class="text-2xl font-bold text-gray-800" x-text="stats.total_ratings"></p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full text-yellow-600"><i class="fas fa-star text-xl"></i></div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 sm:p-6 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase">Total Reviews</h3>
                        <p class="text-2xl font-bold text-gray-800" x-text="stats.total_reviews"></p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-full text-purple-600"><i class="fas fa-comment-dots text-xl"></i></div>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="mt-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100 sm:p-6">
                <h3 class="text-base font-semibold text-gray-600 mb-4">Daily Rating Activity</h3>
                <div class="h-64">
                    <canvas id="ratingsChart"></canvas>
                </div>
            </div>
        </section>

        <!-- 2. Content Performance -->
        <section class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Content Performance</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Most Viewed Movies -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b"><h3 class="font-semibold text-gray-700">Most Viewed Movies</h3></div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.top_movies" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-sm text-gray-800" x-text="item.title"></p>
                                    <p class="text-xs text-gray-500">Rating: <span x-text="item.average_rating || 'N/A'"></span></p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="item.views + ' views'"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Most Viewed Songs -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b"><h3 class="font-semibold text-gray-700">Most Viewed Songs</h3></div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.top_songs" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-sm text-gray-800" x-text="item.title"></p>
                                    <p class="text-xs text-gray-500">Rating: <span x-text="item.average_rating || 'N/A'"></span></p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="item.views + ' views'"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Most Viewed Artists -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b"><h3 class="font-semibold text-gray-700">Most Viewed Artists</h3></div>
                    <ul class="divide-y divide-gray-100">
                        <template x-for="item in stats.top_artists" :key="item.id">
                            <li class="p-4 flex justify-between items-center hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-sm text-gray-800" x-text="item.title"></p>
                                    <p class="text-xs text-gray-500">Rating: <span x-text="item.average_rating || 'N/A'"></span></p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full" x-text="item.views + ' views'"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 3. Moderation Panel -->
        <section class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Moderation Panel</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Action Cards -->
                <div class="space-y-4">
                    <div class="bg-red-50 p-4 rounded-lg border border-red-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-red-700">Pending Reports</h4>
                            <p class="text-sm text-red-600">User generated content flags.</p>
                        </div>
                        <div class="text-3xl font-black text-red-700" x-text="stats.pending_reports"></div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg border border-orange-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-orange-700">Pending Reviews</h4>
                            <p class="text-sm text-orange-600">Reviews flagged for moderation.</p>
                        </div>
                        <div class="text-3xl font-black text-orange-700" x-text="stats.pending_reviews"></div>
                    </div>
                </div>

                <!-- Recently Added -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b"><h3 class="font-semibold text-gray-700">Recently Added Content</h3></div>
                    <ul class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
                        <template x-for="item in stats.recent_added" :key="item.id">
                            <li class="p-4 flex flex-col hover:bg-gray-50">
                                <span class="font-medium text-sm text-gray-800" x-text="item.title"></span>
                                <span class="text-xs text-gray-400 mt-1" x-text="new Date(item.created_at).toLocaleString()"></span>
                            </li>
                        </template>
                    </ul>
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
            chartInstance: null,

            async fetchStats() {
                try {
                    const response = await fetch('/api/admin/stats');
                    if (!response.ok) throw new Error('API Error');
                    this.stats = await response.json();
                    
                    this.loading = false;
                    
                    // Render chart after DOM updates
                    this.$nextTick(() => {
                        this.renderChart();
                    });

                } catch (error) {
                    console.error("Failed to fetch dashboard stats", error);
                }
            },

            renderChart() {
                const ctx = document.getElementById('ratingsChart');
                if (!ctx) return;

                const dailyData = this.stats.daily_ratings || [];
                // Reverse to show chronological left to right
                const sortedData = dailyData.reverse();
                const labels = sortedData.map(item => item.date);
                const dataCounts = sortedData.map(item => item.count);

                if(this.chartInstance) {
                    this.chartInstance.destroy();
                }

                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Ratings Submitted',
                            data: dataCounts,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#2563eb'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }
        }));
    });
</script>
@endsection
