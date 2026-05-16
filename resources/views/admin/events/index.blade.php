@extends('layouts.admin')

@section('page-title', 'Event Moderation')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight uppercase">EVENT MODERATION</h1>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Manage user submitted events and cultural happenings</p>
        </div>
        
        <div class="flex items-center gap-3">
             <form action="{{ route('admin.events.index') }}" method="GET" class="flex gap-2">
                <select name="approval_status" onchange="this.form.submit()" class="bg-white border border-gray-200 text-gray-700 rounded-xl px-4 py-2 text-xs font-bold focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                <i class="fas fa-check text-xs"></i>
            </div>
            <p class="text-sm font-bold text-emerald-600">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white border border-gray-100 rounded-[2rem] overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-widest font-black text-gray-400 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-5">Event</th>
                    <th class="px-6 py-5">Organizer</th>
                    <th class="px-6 py-5">Date</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($events as $event)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-16 h-10 shrink-0">
                                    <img src="{{ $event->poster_url }}" class="w-full h-full object-cover rounded-lg shadow-sm">
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-800">{{ $event->title }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $event->event_type }} • {{ $event->city }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-gray-600">{{ $event->organizer_name }}</p>
                            <p class="text-[10px] text-gray-400">{{ $event->contact_email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-gray-600">{{ $event->start_datetime->format('d M, Y') }}</p>
                            <p class="text-[10px] text-gray-400">{{ $event->start_datetime->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $approvalColor = match($event->approval_status) {
                                    'pending' => 'bg-amber-100 text-amber-600',
                                    'approved' => 'bg-emerald-100 text-emerald-600',
                                    'rejected' => 'bg-rose-100 text-rose-600',
                                };
                            @endphp
                            <span class="{{ $approvalColor }} text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest">
                                {{ $event->approval_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($event->approval_status !== 'approved')
                                    <form action="{{ route('admin.events.approve', $event) }}" method="POST">
                                        @csrf
                                        <button title="Approve" class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-check text-[10px]"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($event->approval_status !== 'rejected')
                                    <form action="{{ route('admin.events.reject', $event) }}" method="POST">
                                        @csrf
                                        <button title="Reject" class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.events.edit', $event) }}" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-times text-gray-200 text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">No events found for moderation</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-8">
        {{ $events->links() }}
    </div>
</div>
@endsection
