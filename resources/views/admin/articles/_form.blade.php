@php
    $isEdit = isset($article);
    $formUid = 'article-' . uniqid();
@endphp

<div x-data="{ langTab: 'hi' }" class="grid grid-cols-1 gap-6 lg:grid-cols-12">
    <!-- Main Content Area -->
    <div class="space-y-6 lg:col-span-9">
        <!-- Prominent Title Area -->
        <div class="space-y-4">
            <div x-show="langTab === 'hi'">
                <input type="text" name="title_hi" value="{{ old('title_hi', $article->title_hi ?? '') }}"
                    class="w-full border-0 border-b border-gray-200 bg-transparent px-0 py-3 text-4xl font-bold text-gray-900 focus:border-accent focus:ring-0" 
                    placeholder="Add title (Hindi) *" required>
            </div>
            <div x-show="langTab === 'en'">
                <input type="text" name="title_en" value="{{ old('title_en', $article->title_en ?? '') }}"
                    class="w-full border-0 border-b border-gray-200 bg-transparent px-0 py-3 text-4xl font-bold text-gray-900 focus:border-accent focus:ring-0" 
                    placeholder="Add title (English)">
            </div>
            <div x-show="langTab === 'chh'">
                <input type="text" name="title_chh" value="{{ old('title_chh', $article->title_chh ?? '') }}"
                    class="w-full border-0 border-b border-gray-200 bg-transparent px-0 py-3 text-4xl font-bold text-gray-900 focus:border-accent focus:ring-0" 
                    placeholder="Add title (Chhattisgarhi)">
            </div>
        </div>

        <!-- Content Editor Section -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-4 py-2">
                <div class="flex gap-4">
                    <button type="button" @click="langTab='hi'"
                        :class="langTab === 'hi' ? 'text-accent font-bold border-b-2 border-accent' : 'text-gray-500 hover:text-gray-700'"
                        class="px-2 py-1 text-sm transition">Hindi</button>
                    <button type="button" @click="langTab='en'"
                        :class="langTab === 'en' ? 'text-accent font-bold border-b-2 border-accent' : 'text-gray-500 hover:text-gray-700'"
                        class="px-2 py-1 text-sm transition">English</button>
                    <button type="button" @click="langTab='chh'"
                        :class="langTab === 'chh' ? 'text-accent font-bold border-b-2 border-accent' : 'text-gray-500 hover:text-gray-700'"
                        class="px-2 py-1 text-sm transition">Chhattisgarhi</button>
                </div>
                <div class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Article Content</div>
            </div>

            <div class="p-0">
                <div x-show="langTab === 'hi'" class="space-y-2">
                    <div id="{{ $formUid }}-editor-hi" class="article-rich-editor border-0"></div>
                    <textarea id="{{ $formUid }}-content-hi" name="content_hi" class="hidden" required>{{ old('content_hi', $article->content_hi ?? '') }}</textarea>
                </div>

                <div x-show="langTab === 'en'" class="space-y-2">
                    <div id="{{ $formUid }}-editor-en" class="article-rich-editor border-0"></div>
                    <textarea id="{{ $formUid }}-content-en" name="content_en" class="hidden">{{ old('content_en', $article->content_en ?? '') }}</textarea>
                </div>

                <div x-show="langTab === 'chh'" class="space-y-2">
                    <div id="{{ $formUid }}-editor-chh" class="article-rich-editor border-0"></div>
                    <textarea id="{{ $formUid }}-content-chh" name="content_chh" class="hidden">{{ old('content_chh', $article->content_chh ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <!-- Excerpts Section -->
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Excerpts</h3>
            <div class="space-y-4">
                <div x-show="langTab === 'hi'">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Excerpt (Hindi)</label>
                    <textarea name="excerpt_hi" rows="3" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent" placeholder="Write a short summary...">{{ old('excerpt_hi', $article->excerpt_hi ?? '') }}</textarea>
                </div>
                <div x-show="langTab === 'en'">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Excerpt (English)</label>
                    <textarea name="excerpt_en" rows="3" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent" placeholder="Write a short summary...">{{ old('excerpt_en', $article->excerpt_en ?? '') }}</textarea>
                </div>
                <div x-show="langTab === 'chh'">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Excerpt (Chhattisgarhi)</label>
                    <textarea name="excerpt_chh" rows="3" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent" placeholder="Write a short summary...">{{ old('excerpt_chh', $article->excerpt_chh ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <!-- SEO Section -->
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Search Engine Optimization</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">SEO Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title ?? '') }}"
                        class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="2" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </section>
    </div>

    <!-- Sidebar Area -->
    <aside class="space-y-6 lg:col-span-3">
        <!-- Publish Widget -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700">Publish</div>
            <div class="p-4 space-y-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Status:</span>
                    <select name="status" class="border-0 p-0 text-sm font-bold text-accent focus:ring-0 bg-transparent">
                        <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status ?? 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Publish:</span>
                    <input type="datetime-local" name="published_at"
                        value="{{ old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\\TH:i') : '') }}"
                        class="border-0 p-0 text-sm font-bold text-accent focus:ring-0 bg-transparent">
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    <span>Slug:</span>
                    <input type="text" name="slug" value="{{ old('slug', $article->slug ?? '') }}"
                        class="w-full border-0 p-0 text-xs text-gray-500 focus:ring-0 bg-transparent" placeholder="auto-generated">
                </div>
            </div>
            <div class="bg-gray-50 border-t border-gray-100 px-4 py-3 flex justify-between items-center">
                @if(isset($article))
                    <button type="submit" name="delete" class="text-xs text-red-600 hover:underline">Move to Trash</button>
                @else
                    <div></div>
                @endif
                <button type="submit" class="rounded bg-accent px-4 py-1.5 text-xs font-bold text-white hover:bg-accent-dark transition">
                    {{ isset($article) ? 'Update' : 'Publish' }}
                </button>
            </div>
        </section>

        <!-- Categories Widget -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden" x-data="{ 
            newCategoryName: '', 
            showAdd: false,
            async submitCategory() {
                if (!this.newCategoryName.trim()) return;
                try {
                    const response = await fetch('{{ route('admin.article-categories.store') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                        body: JSON.stringify({ name: this.newCategoryName })
                    });
                    const data = await response.json();
                    if (data.success) {
                        const select = document.getElementById('category_id');
                        const option = new Option(data.category.name, data.category.id, true, true);
                        select.add(option);
                        this.newCategoryName = '';
                        this.showAdd = false;
                    }
                } catch (e) { console.error(e); }
            }
        }">
            <div class="border-b border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700">Categories</div>
            <div class="p-4">
                <select name="category_id" id="category_id" class="w-full rounded border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent">
                    <option value="">Uncategorized</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="mt-2">
                    <button type="button" @click="showAdd = !showAdd" class="text-xs text-accent hover:underline">+ Add New Category</button>
                    <div x-show="showAdd" class="mt-2 space-y-2">
                        <input type="text" x-model="newCategoryName" class="w-full rounded border-gray-300 text-xs" placeholder="Category name...">
                        <button type="button" @click="submitCategory" class="rounded bg-gray-100 px-3 py-1 text-xs font-bold text-gray-700 hover:bg-gray-200">Add</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tags Widget -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700">Tags</div>
            <div class="p-4">
                <input type="text" name="tags_input" value="{{ old('tags_input', $tagsInput ?? '') }}"
                    class="w-full rounded border-gray-300 text-sm shadow-sm focus:border-accent focus:ring-accent" placeholder="Separate with commas">
                <p class="mt-2 text-[10px] text-gray-400">Separate tags with commas</p>
            </div>
        </section>

        <!-- Featured Image Widget -->
        <section class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-700">Featured Image</div>
            <div class="p-4">
                @if($isEdit && !empty($article->featured_image))
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="w-full h-32 rounded object-cover border border-gray-100">
                    </div>
                @endif
                <input type="file" name="featured_image" class="w-full text-xs text-gray-500 file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-accent file:text-white hover:file:bg-accent-dark cursor-pointer" accept="image/*">
            </div>
        </section>
    </aside>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
    (function () {
        const initEditor = (editorId, textareaId) => {
            const editorEl = document.getElementById(editorId);
            const textareaEl = document.getElementById(textareaId);
            if (!editorEl || !textareaEl || editorEl.dataset.ready === '1') return;

            const quill = new Quill(editorEl, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'code-block', 'link', 'image', 'video'],
                        ['clean']
                    ],
                },
            });

            quill.root.innerHTML = textareaEl.value || '';
            quill.on('text-change', function () {
                textareaEl.value = quill.root.innerHTML;
            });

            const form = textareaEl.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    textareaEl.value = quill.root.innerHTML;
                });
            }

            editorEl.dataset.ready = '1';
        };

        document.addEventListener('DOMContentLoaded', function () {
            initEditor('{{ $formUid }}-editor-hi', '{{ $formUid }}-content-hi');
            initEditor('{{ $formUid }}-editor-en', '{{ $formUid }}-content-en');
            initEditor('{{ $formUid }}-editor-chh', '{{ $formUid }}-content-chh');
        });
    })();
</script>

<style>
    .article-rich-editor .ql-editor {
        min-height: 320px;
        font-size: 15px;
        line-height: 1.6;
    }
    .article-rich-editor .ql-toolbar.ql-snow {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border-color: rgb(209 213 219);
        background: rgb(248 250 252);
    }
    .article-rich-editor .ql-container.ql-snow {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border-color: rgb(209 213 219);
    }
</style>
