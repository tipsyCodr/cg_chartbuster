@extends('layouts.admin')

@section('page-title', 'Articles')

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="rounded bg-accent px-4 py-2 text-sm font-semibold text-white hover:bg-accent-dark transition">
            Add New
        </a>
    </div>

    <!-- WP Status Filters -->
    <div class="mb-4 flex items-center gap-4 text-sm text-gray-600">
        <div class="flex items-center divide-x divide-gray-300">
            <a href="{{ route('admin.articles.index') }}" class="pr-3 {{ !request('status') ? 'font-bold text-gray-900' : 'text-accent hover:underline' }}">
                All <span class="text-xs font-normal text-gray-400">({{ $counts['all'] }})</span>
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'published']) }}" class="px-3 {{ request('status') === 'published' ? 'font-bold text-gray-900' : 'text-accent hover:underline' }}">
                Published <span class="text-xs font-normal text-gray-400">({{ $counts['published'] }})</span>
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'draft']) }}" class="pl-3 {{ request('status') === 'draft' ? 'font-bold text-gray-900' : 'text-accent hover:underline' }}">
                Drafts <span class="text-xs font-normal text-gray-400">({{ $counts['draft'] }})</span>
            </a>
        </div>
        <div class="ml-auto">
            <form action="{{ route('admin.articles.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search articles..." 
                       class="rounded-lg border-gray-300 py-1 text-sm shadow-sm focus:border-accent focus:ring-accent">
                <button type="submit" class="rounded-lg bg-gray-100 px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-gray-200">Search</button>
            </form>
        </div>
    </div>

    <!-- WP Bulk Actions & Filters -->
    <form action="{{ route('admin.articles.index') }}" method="GET" class="mb-3 flex flex-wrap gap-2 text-sm">
        <select class="rounded-lg border-gray-300 py-1 text-sm shadow-sm focus:border-accent">
            <option>Bulk Actions</option>
            <option>Edit</option>
            <option>Move to Trash</option>
        </select>
        <button type="button" class="rounded-lg bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:bg-gray-200">Apply</button>

        <select name="category" class="ml-3 rounded-lg border-gray-300 py-1 text-sm shadow-sm focus:border-accent">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-gray-100 px-3 py-1 font-semibold text-gray-700 hover:bg-gray-200">Filter</button>
    </form>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-8 px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-accent focus:ring-accent"></th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Categories</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Tags</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($articles as $article)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3"><input type="checkbox" class="rounded border-gray-300 text-accent focus:ring-accent"></td>
                        <td class="px-4 py-3">
                            <div class="relative">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="block font-bold text-[#2271b1] hover:text-[#135e96]">
                                    {{ $article->title_hi }}
                                    @if($article->status === 'draft')
                                        <span class="ml-1 text-xs font-normal text-gray-500">— Draft</span>
                                    @endif
                                </a>
                                <!-- Actions on hover -->
                                <div class="mt-1 flex gap-2 text-[11px] opacity-0 transition-opacity group-hover:opacity-100">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-[#2271b1] hover:text-[#135e96]">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    {{-- <button class="text-accent hover:text-accent-dark">Quick Edit</button> --}}
                                    {{-- <span class="text-gray-300">|</span> --}}
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Move to Trash?')" class="text-red-600 hover:text-red-800">Trash</button>
                                    </form>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('articles.show', ['slug' => $article->slug]) }}" target="_blank" class="text-[#2271b1] hover:text-[#135e96]">View</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-[#2271b1]">{{ $article->author?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-[#2271b1]">{{ optional($article->category)->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if(is_array($article->tags) && count($article->tags) > 0)
                                {{ implode(', ', $article->tags) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            @if($article->status === 'published')
                                <div class="font-medium text-gray-900">Published</div>
                                <div>{{ optional($article->published_at)->format('Y/m/d \a\t g:i a') }}</div>
                            @else
                                <div class="font-medium text-gray-900">Last Modified</div>
                                <div>{{ $article->updated_at->format('Y/m/d \a\t g:i a') }}</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-500">No articles found matching your criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $articles->links() }}</div>
 @endsection
