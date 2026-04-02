@php
    $isEdit = isset($article);
    $formUid = 'article-' . uniqid();
@endphp

<div x-data="{ langTab: 'hi' }" class="grid grid-cols-1 gap-5 lg:grid-cols-12">
    <div class="space-y-6 lg:col-span-8">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Title & Excerpt</h3>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title (Hindi) *</label>
                <input type="text" name="title_hi" value="{{ old('title_hi', $article->title_hi ?? '') }}"
                    class="mt-1 w-full rounded-lg border-gray-300 text-lg shadow-sm" required>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title (English)</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $article->title_en ?? '') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title (Chhattisgarhi)</label>
                    <input type="text" name="title_chh" value="{{ old('title_chh', $article->title_chh ?? '') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Excerpt (Hindi)</label>
                    <textarea name="excerpt_hi" rows="3" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">{{ old('excerpt_hi', $article->excerpt_hi ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Excerpt (English)</label>
                    <textarea name="excerpt_en" rows="3" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">{{ old('excerpt_en', $article->excerpt_en ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Excerpt (Chhattisgarhi)</label>
                    <textarea name="excerpt_chh" rows="3" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">{{ old('excerpt_chh', $article->excerpt_chh ?? '') }}</textarea>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-gray-800">Article Content</h3>
                <div class="inline-flex rounded-lg border border-gray-300 bg-gray-50 p-1 text-sm">
                    <button type="button" @click="langTab='hi'"
                        :class="langTab === 'hi' ? 'bg-white shadow text-gray-900' : 'text-gray-600'"
                        class="rounded-md px-3 py-1.5 font-medium transition">Hindi</button>
                    <button type="button" @click="langTab='en'"
                        :class="langTab === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-600'"
                        class="rounded-md px-3 py-1.5 font-medium transition">English</button>
                    <button type="button" @click="langTab='chh'"
                        :class="langTab === 'chh' ? 'bg-white shadow text-gray-900' : 'text-gray-600'"
                        class="rounded-md px-3 py-1.5 font-medium transition">Chhattisgarhi</button>
                </div>
            </div>

            <div x-show="langTab === 'hi'" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Content (Hindi) *</label>
                <div id="{{ $formUid }}-editor-hi" class="article-rich-editor rounded-lg border border-gray-300"></div>
                <textarea id="{{ $formUid }}-content-hi" name="content_hi" class="hidden" required>{{ old('content_hi', $article->content_hi ?? '') }}</textarea>
            </div>

            <div x-show="langTab === 'en'" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Content (English)</label>
                <div id="{{ $formUid }}-editor-en" class="article-rich-editor rounded-lg border border-gray-300"></div>
                <textarea id="{{ $formUid }}-content-en" name="content_en" class="hidden">{{ old('content_en', $article->content_en ?? '') }}</textarea>
            </div>

            <div x-show="langTab === 'chh'" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Content (Chhattisgarhi)</label>
                <div id="{{ $formUid }}-editor-chh" class="article-rich-editor rounded-lg border border-gray-300"></div>
                <textarea id="{{ $formUid }}-content-chh" name="content_chh" class="hidden">{{ old('content_chh', $article->content_chh ?? '') }}</textarea>
            </div>
        </section>
    </div>

    <aside class="space-y-6 lg:col-span-4 lg:sticky lg:top-6 lg:self-start">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Publish</h3>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                    <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $article->status ?? 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Publish Date</label>
                <input type="datetime-local" name="published_at"
                    value="{{ old('published_at', isset($article) && $article->published_at ? $article->published_at->format('Y-m-d\\TH:i') : '') }}"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Permalink Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $article->slug ?? '') }}"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" placeholder="auto-from-hindi-title-if-empty">
                <p class="mt-1 text-xs text-gray-500">Example: angana-movie-review</p>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Taxonomy</h3>

            <div class="mb-3" x-data="{ 
                newCategoryName: '', 
                isModalOpen: false,
                isSubmitting: false,
                async submitCategory() {
                    if (!this.newCategoryName.trim()) return;
                    this.isSubmitting = true;
                    try {
                        const response = await fetch('{{ route('admin.article-categories.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });
                        const data = await response.json();
                        if (data.success) {
                            const select = document.getElementById('category_id');
                            const option = new Option(data.category.name, data.category.id, true, true);
                            select.add(option);
                            this.newCategoryName = '';
                            this.isModalOpen = false;
                        } else {
                            alert(data.message || 'Error creating category');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while creating the category');
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }">
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <button type="button" @click="isModalOpen = true" class="text-xs font-semibold text-accent hover:text-accent-dark">
                        + Add New
                    </button>
                </div>
                <select name="category_id" id="category_id" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Modal -->
                <template x-teleport="body">
                    <div x-show="isModalOpen" 
                         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        
                        <div @click.away="isModalOpen = false" 
                             class="w-full max-w-md overflow-hidden bg-white rounded-xl shadow-2xl"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="scale-95 opacity-0"
                             x-transition:enter-end="scale-100 opacity-100">
                            
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-gray-800">Add New Category</h3>
                                <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <div class="p-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" x-model="newCategoryName" @keydown.enter.prevent="submitCategory"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-accent focus:border-accent"
                                       placeholder="e.g. Reviews, News, Interviews" autofocus>
                            </div>
                            
                            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                                <button type="button" @click="isModalOpen = false" 
                                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800">
                                    Cancel
                                </button>
                                <button type="button" @click="submitCategory" :disabled="isSubmitting"
                                        class="px-4 py-2 text-sm font-semibold text-white bg-accent rounded-lg hover:bg-accent-dark disabled:opacity-50 flex items-center gap-2">
                                    <span x-show="isSubmitting" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                                    Create Category
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tags (comma separated)</label>
                <input type="text" name="tags_input" value="{{ old('tags_input', $tagsInput ?? '') }}"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm" placeholder="angana, movie review, cg cinema">
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Featured Image</h3>
            <input type="file" name="featured_image" class="w-full rounded-lg border-gray-300 shadow-sm" accept="image/*">
            @if($isEdit && !empty($article->featured_image))
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="" class="mt-3 h-24 rounded-lg border border-gray-200 object-cover">
            @endif
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm ring-1 ring-black/5">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">SEO</h3>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $article->meta_title ?? '') }}"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                <textarea name="meta_description" rows="3" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
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
