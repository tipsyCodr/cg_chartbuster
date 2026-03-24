@extends('layouts.admin')

@section('page-title', 'Edit Article')

@section('content')
    @if($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data"
        class="rounded-xl border border-gray-200 bg-[#f8fafc] p-4 shadow-sm sm:p-6">
        @csrf
        @method('PUT')
        @include('admin.articles._form')

        <div class="mt-6 flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.articles.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-accent px-5 py-2.5 text-sm font-semibold text-white hover:bg-accent-dark">
                Update Article
            </button>
        </div>
    </form>
@endsection
