<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use App\Models\User;
use Livewire\Component;

class NotificationDropdown extends Component
{
    public function render()
    {
        $reports = Report::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($report) {
                return [
                    'type' => 'report',
                    'title' => 'Content flagged for review',
                    'description' => 'New report: ' . ($report->reason ?? 'Reason not specified'),
                    'time' => $report->created_at,
                    'icon' => 'fas fa-flag',
                    'color' => 'amber',
                    'link' => route('admin.dashboard'), // Adjust to report management when available
                ];
            });

        $users = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'title' => 'New user registered',
                    'description' => $user->name . ' joined the platform.',
                    'time' => $user->created_at,
                    'icon' => 'fas fa-user-plus',
                    'color' => 'blue',
                    'link' => route('admin.user-management'),
                ];
            });

        $notifications = $reports->concat($users)->sortByDesc('time')->take(10);
        
        // Count reports and users from the last 24 hours as "new"
        $newReportsCount = Report::where('status', 'pending')->count();
        $unreadCount = $newReportsCount;

        return view('livewire.admin.notification-dropdown', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
