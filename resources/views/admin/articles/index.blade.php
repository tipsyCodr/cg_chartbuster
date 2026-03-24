@extends('layouts.admin')

@section('page-title', 'Articles')

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Article Management</h1>
        <a href="{{ route('admin.articles.create') }}" class="rounded bg-accent px-4 py-2 text-white hover:bg-accent-dark">
            Add Article
        </a>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Article</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Published</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($articles as $article)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $article->title_hi }}</p>
                            <p class="text-xs text-gray-500">/{{ $article->slug }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $article->category ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $article->author?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="rounded-full px-2 py-1 text-xs {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ optional($article->published_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="mr-3 text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this article?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No articles yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $articles->links() }}</div>
@endsection
