@extends('layouts.admin')

@section('page-title', 'Platform Analytics')

@section('content')
<div x-data="dashboardAnalytics()" x-init="fetchStats()" class="space-y-8 pb-20">

    <!-- Loading Overlay -->
    <div x-show="loading" 
         class="fixed inset-0 z-[60] bg-white/70 backdrop-blur-sm flex flex-col items-center justify-center transition-opacity" 
         x-transition:leave="opacity-0 duration-500">
        <div class="relative w-20 h-20">
            <div class="absolute inset-0 border-4 border-blue-100 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
        </div>
        <p class="mt-6 text-sm font-black text-gray-800 tracking-widest uppercase animate-pulse">Syncing real-time intelligence...</p>
    </div>

    <div x-show="!loading" x-cloak class="space-y-10">

        <!-- KPI Grid -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-gray-800 tracking-tight">Platform Performance</h2>
                </div>
                <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1.5 rounded-xl tracking-widest uppercase shadow-sm">Real-time Stream Active</span>
            </div>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <x-admin.stats-card 
                    label="Total Visibility" 
                    value="stats.visitor_stats?.total_page_views || 0" 
                    icon="fas fa-eye" 
                    color="blue">
                    <span class="text-blue-600 font-bold" x-text="'+' + (stats.visitor_stats?.total_visitors_today || 0)"></span>
                    <span class="ml-1">impressions today</span>
                </x-admin.stats-card>

                <x-admin.stats-card 
                    label="Unique Reach" 
                    value="stats.visitor_stats?.unique_visitors || 0" 
                    icon="fas fa-fingerprint" 
                    color="indigo">
                    <span class="text-indigo-600 font-bold" x-text="stats.visitor_stats?.total_visitors_month || 0"></span>
                    <span class="ml-1">unique this month</span>
                </x-admin.stats-card>

                <x-admin.stats-card 
                    label="Total Registry" 
                    value="stats.overview?.total_users || 0" 
                    icon="fas fa-users" 
                    color="emerald">
                    <span class="text-emerald-600 font-bold" x-text="'+' + (stats.visitor_stats?.new_users_month || 0)"></span>
                    <span class="ml-1">growth this month</span>
                </x-admin.stats-card>

                <x-admin.stats-card 
                    label="User Affinity" 
                    value="stats.user_engagement?.total_watchlist_adds || 0" 
                    icon="fas fa-heart" 
                    color="rose">
                    <span class="uppercase tracking-widest font-black text-[9px] text-gray-400">Watchlist Intensity</span>
                </x-admin.stats-card>
            </div>
        </section>

        <!-- Dynamic Visualization Section -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-admin.card title="Traffic Vector Analysis">
                <div class="flex items-center space-x-2 mb-6 -mt-2">
                    <span class="w-3 h-1.5 bg-blue-500 rounded-full"></span>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">30-Day Aggregation</span>
                </div>
                <div class="h-72">
                    <canvas id="trafficTrendChart"></canvas>
                </div>
            </x-admin.card>

            <x-admin.card title="Interaction Velocity">
                <div class="flex items-center space-x-2 mb-6 -mt-2">
                    <span class="w-3 h-1.5 bg-purple-500 rounded-full"></span>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Daily Rating Activity</span>
                </div>
                <div class="h-72">
                    <canvas id="ratingsChart"></canvas>
                </div>
            </x-admin.card>
        </section>

        <!-- Trending Content Intelligence -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                    <h2 class="text-xl font-black text-gray-800 tracking-tight">Viral Content Matrix</h2>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 bg-rose-500 rounded-full animate-ping"></span>
                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Last 7 Days</span>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <template x-for="item in stats.trending" :key="item.type + item.id">
                    <div class="group relative overflow-hidden bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute -right-2 -top-2 w-16 h-16 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                        
                        <div class="relative z-10">
                            <span class="inline-block text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg uppercase tracking-widest mb-3" x-text="item.type"></span>
                            <h4 class="text-sm font-black text-gray-800 line-clamp-2 leading-tight min-h-[2.5rem]" x-text="item.title"></h4>
                            
                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                <div class="flex items-center text-blue-500">
                                    <i class="fas fa-chart-line text-[10px] mr-1.5 opacity-50"></i>
                                    <span class="text-xs font-black" x-text="item.views.toLocaleString()"></span>
                                </div>
                                <div class="w-12 h-1 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full" :style="`width: ${Math.min((item.views / stats.trending[0]?.views) * 100, 100)}%`"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div x-show="!stats.trending?.length" class="bg-gray-50/50 p-16 rounded-3xl border-2 border-dashed border-gray-100 text-center flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center text-gray-200 mb-4">
                    <i class="fas fa-database text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-400">Zero traffic data points detected for current interval.</p>
            </div>
        </section>

        <!-- Moderation Intelligence -->
        <section class="space-y-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-1.5 h-6 bg-rose-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-gray-800 tracking-tight">Moderation Hub</h2>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm">
                        <span x-text="stats.moderation?.pending_reports_count"></span> Severe Reports
                    </div>
                    <div class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-100 shadow-sm">
                        <span x-text="stats.moderation?.pending_reviews_count"></span> User Flags
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Flagged Reviews -->
                <x-admin.card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between w-full">
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Flagged Reviews</h3>
                            <button @click="fetchStats()" class="p-2 hover:bg-gray-100 rounded-xl transition-colors"><i class="fas fa-sync-alt text-xs text-gray-400"></i></button>
                        </div>
                    </x-slot>
                    
                    <div class="overflow-y-auto max-h-[450px] -mx-6 -my-6">
                        <x-admin.table :headers="['Reviewer & Content', 'Review Text', ['label'=>'Control', 'align'=>'right']]" :hasBorder="false">
                            <template x-for="review in stats.moderation?.flagged_reviews" :key="review.id">
                                <tr class="group hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-black mr-3 shadow-sm group-hover:scale-110 transition-transform">
                                                <span x-text="(review.user?.name || 'A').charAt(0)"></span>
                                            </div>
                                            <div>
                                                <div class="text-xs font-black text-gray-800" x-text="review.user?.name || 'Anonymous User'"></div>
                                                <div class="text-[10px] text-blue-500 font-bold bg-blue-50 px-2 py-0.5 rounded-lg mt-1 inline-block" 
                                                     x-text="(review.movie?.title || review.song?.title || review.artist?.name || review.tvshow?.title)"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-[11px] text-gray-500 line-clamp-3 leading-relaxed italic border-l-2 border-gray-100 pl-3" x-text="'&ldquo;' + review.review_text + '&rdquo;'"></p>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <x-admin.button size="xs" variant="success" @click="moderateReview(review.id, 'approve')">Allow</x-admin.button>
                                            <x-admin.button size="xs" variant="danger" @click="moderateReview(review.id, 'reject')">Purge</x-admin.button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </x-admin.table>
                        
                        <div x-show="!stats.moderation?.flagged_reviews?.length" class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Queue Clean</p>
                        </div>
                    </div>
                </x-admin.card>

                <!-- Content Reports -->
                <x-admin.card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between w-full">
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Severity Reports</h3>
                            <x-admin.button variant="ghost" size="xs">Export Logs</x-admin.button>
                        </div>
                    </x-slot>
                    
                    <div class="overflow-y-auto max-h-[450px] -mx-6 -my-6">
                        <x-admin.table :headers="['Source', 'Entity/Reason', ['label'=>'Control', 'align'=>'right']]" :hasBorder="false">
                            <template x-for="report in stats.moderation?.pending_reports" :key="report.id">
                                <tr class="hover:bg-gray-50/50 transition border-b border-gray-50 last:border-0">
                                    <td class="px-6 py-5">
                                        <div class="text-xs font-black text-gray-800" x-text="report.reporter_name"></div>
                                        <div class="text-[9px] text-gray-400 font-bold mt-1" x-text="new Date(report.created_at).toLocaleDateString()"></div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="inline-block text-[9px] font-black text-rose-600 bg-rose-50 px-2 py-0.5 rounded uppercase tracking-widest mb-1.5" 
                                             x-text="report.reportable_type.split('\\').pop()"></div>
                                        <p class="text-[10px] text-gray-500 leading-tight font-medium" x-text="report.reason"></p>
                                    </td>
                                    <td class="px-6 py-5 text-right font-bold">
                                        <div class="flex justify-end space-x-2">
                                            <x-admin.button size="xs" variant="primary" @click="resolveReport(report.id, 'resolved')">Resolve</x-admin.button>
                                            <x-admin.button size="xs" variant="secondary" @click="resolveReport(report.id, 'rejected')">Ignore</x-admin.button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </x-admin.table>
                        
                        <div x-show="!stats.moderation?.pending_reports?.length" class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-4">
                                <i class="fas fa-shield-alt text-2xl"></i>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No Active Reports</p>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </section>

        <!-- Media Velocity Dashboards -->
        <section>
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                <h2 class="text-xl font-black text-gray-800 tracking-tight">Catalyst Intelligence</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Top Movies -->
                <x-admin.card title="Movie Velocity">
                   <div class="space-y-4 -mx-6 -my-2">
                        <template x-for="item in stats.content_performance?.top_movies" :key="item.id">
                            <div class="group flex items-center justify-between p-4 px-6 hover:bg-gray-50 transition-all border-b border-gray-50 last:border-0">
                                <div class="truncate flex-1 pr-4">
                                    <p class="text-xs font-black text-gray-800 truncate group-hover:text-blue-600 transition-colors" x-text="item.title"></p>
                                    <div class="flex items-center mt-1.5">
                                        <div class="flex text-amber-400 text-[8px] space-x-0.5">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star" :class="i <= Math.round(item.average_rating) ? 'text-amber-400' : 'text-gray-100'"></i>
                                            </template>
                                        </div>
                                        <span class="text-[9px] font-black text-gray-300 ml-2" x-text="parseFloat(item.average_rating).toFixed(1)"></span>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-lg shadow-sm" x-text="item.views.toLocaleString()"></span>
                            </div>
                        </template>
                   </div>
                </x-admin.card>

                <!-- Top Songs -->
                <x-admin.card title="Audio Traction">
                    <div class="space-y-4 -mx-6 -my-2">
                        <template x-for="item in stats.content_performance?.top_songs" :key="item.id">
                            <div class="group flex items-center justify-between p-4 px-6 hover:bg-gray-50 transition-all border-b border-gray-50 last:border-0">
                                <div class="truncate flex-1 pr-4">
                                    <p class="text-xs font-black text-gray-800 truncate group-hover:text-indigo-600 transition-colors" x-text="item.title"></p>
                                    <div class="flex items-center mt-1.5">
                                        <div class="flex text-amber-400 text-[8px] space-x-0.5">
                                            <template x-for="i in 5">
                                                <i class="fas fa-star" :class="i <= Math.round(item.average_rating) ? 'text-amber-400' : 'text-gray-100'"></i>
                                            </template>
                                        </div>
                                        <span class="text-[9px] font-black text-gray-300 ml-2" x-text="parseFloat(item.average_rating).toFixed(1)"></span>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg shadow-sm" x-text="item.views.toLocaleString()"></span>
                            </div>
                        </template>
                   </div>
                </x-admin.card>

                <!-- Engagement Insights -->
                <x-admin.card title="Influencer Matrix">
                    <div class="space-y-4 pt-2 -mx-2">
                        <template x-for="user in stats.user_engagement?.most_active_users" :key="user.id">
                            <div class="flex items-center justify-between p-3 px-4 bg-gray-50/50 rounded-2xl hover:bg-white hover:shadow-xl hover:scale-[1.02] transition-all duration-300 border border-transparent hover:border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xs font-black shadow-lg shadow-blue-100 mr-3" 
                                         x-text="user.name.charAt(0)"></div>
                                    <div>
                                        <p class="text-xs font-black text-gray-800" x-text="user.name"></p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Active Agent</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-gray-800" x-text="user.reviews_count"></span>
                                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-tighter">Reviews</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </x-admin.card>
            </div>
        </section>

        <!-- Fresh Ingest Flow -->
        <section>
            <x-admin.card>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-6 bg-emerald-600 rounded-full"></div>
                        <h2 class="text-xl font-black text-gray-800 tracking-tight">Recent Ingest History</h2>
                    </div>
                    <x-admin.button variant="secondary" size="sm">Audit Complete Log</x-admin.button>
                </div>

                <div class="-mx-6 -mb-6">
                    <x-admin.table :headers="['Identity & Index', 'Ingest Timestamp', 'Classification', ['label'=>'Control', 'align'=>'right']]" :hasBorder="false">
                        <template x-for="item in stats.moderation?.recent_added" :key="item.id">
                            <tr class="hover:bg-gray-50 transition group capitalize">
                                <td class="px-6 py-5">
                                    <div class="text-sm font-black text-gray-800 group-hover:text-blue-600 transition-colors" x-text="item.title"></div>
                                    <div class="text-[10px] font-bold text-gray-300 mt-1">UUID: #<span x-text="item.id"></span></div>
                                </td>
                                <td class="px-6 py-5 text-xs font-bold text-gray-400" x-text="new Date(item.created_at).toLocaleString()"></td>
                                <td class="px-6 py-5">
                                    <span class="text-[9px] font-black px-3 py-1 rounded-xl bg-gray-100 text-gray-500 uppercase tracking-widest border border-gray-200" x-text="item.type || 'Movie'"></span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end space-x-1">
                                        <button class="p-2 text-gray-300 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"><i class="fas fa-edit text-xs"></i></button>
                                        <button class="p-2 text-gray-300 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"><i class="fas fa-trash-alt text-xs"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </x-admin.table>
                </div>
            </x-admin.card>
        </section>
        
    </div>
</div>

<!-- Visualization Engine -->
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
                    if (!response.ok) throw new Error('API Sync Failure');
                    this.stats = await response.json();
                    this.loading = false;
                    
                    this.$nextTick(() => {
                        this.renderTrafficChart();
                        this.renderRatingsChart();
                    });

                } catch (error) {
                    console.error("Dashboard synchronization error:", error);
                }
            },

            async moderateReview(id, action) {
                if(!confirm(`Confirm moderate: ${action.toUpperCase()} on Review # ${id}?`)) return;
                
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
                    console.error("Review moderation logic failure:", error);
                }
            },

            async resolveReport(id, status) {
                if(!confirm(`Update report status to: ${status.toUpperCase()}?`)) return;
                
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
                    console.error("Report resolution logic failure:", error);
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
                            label: 'Platform Views',
                            data: dataCounts,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.08)',
                            borderWidth: 4,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#3b82f6',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                                ticks: { font: { family: 'Outfit', weight: 'bold', size: 10 }, color: '#94a3b8', padding: 10 }
                            },
                            x: { 
                                grid: { display: false },
                                ticks: { font: { family: 'Outfit', weight: 'bold', size: 10 }, color: '#94a3b8', maxRotation: 0 }
                            }
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

                const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, '#a855f7');
                gradient.addColorStop(1, '#6366f1');

                this.ratingsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'User Ratings',
                            data: dataCounts,
                            backgroundColor: gradient,
                            borderRadius: 12,
                            barThickness: 16
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                                ticks: { font: { family: 'Outfit', weight: 'bold', size: 10 }, color: '#94a3b8', padding: 10 }
                            },
                            x: { 
                                grid: { display: false },
                                ticks: { font: { family: 'Outfit', weight: 'bold', size: 10 }, color: '#94a3b8' }
                            }
                        }
                    }
                });
            }
        }));
    });
</script>
@endsection
