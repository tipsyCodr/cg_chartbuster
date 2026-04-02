@props([
    'name',
    'label' => 'Upload File',
    'accept' => 'image/*',
    'multiple' => false,
    'current' => null,
])

<div x-data="{ 
    isDragging: false, 
    preview: '{{ $current ? Storage::url($current) : '' }}',
    handleDrop(e) {
        this.isDragging = false;
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            this.$refs.fileInput.files = files;
            this.handlePreview(files[0]);
        }
    },
    handlePreview(file) {
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => { this.preview = e.target.result; };
        reader.readAsDataURL(file);
    }
}" 
class="space-y-4">
    <div 
        @dragover.prevent="isDragging = true" 
        @dragleave.prevent="isDragging = false" 
        @drop.prevent="handleDrop($event)"
        :class="{ 'border-blue-500 bg-blue-50/30 ring-4 ring-blue-500/10': isDragging, 'border-gray-100 hover:border-gray-200 bg-gray-50/30': !isDragging }"
        class="relative flex flex-col items-center justify-center w-full min-h-[160px] border-2 border-dashed rounded-2xl transition-all duration-300 cursor-pointer group"
    >
        <input 
            x-ref="fileInput"
            type="file" 
            name="{{ $name }}" 
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            class="absolute inset-0 z-10 w-full h-full opacity-0 cursor-pointer"
            @change="handlePreview($event.target.files[0])"
        >

        <div class="flex flex-col items-center justify-center p-6 text-center space-y-3">
            <div class="w-12 h-12 rounded-xl bg-white shadow-sm border border-gray-50 flex items-center justify-center text-gray-400 group-hover:text-blue-500 transition-all duration-300 transform group-hover:scale-110">
                <i class="fas fa-cloud-upload-alt text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-black text-gray-700 uppercase tracking-widest">{{ $label }}</p>
                <p class="mt-1 text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Drag & drop or click to browse</p>
            </div>
        </div>

        <!-- Preview Overlay -->
        <template x-if="preview">
            <div class="absolute inset-0 z-20 rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-xl group/preview">
                <img :src="preview" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 group-hover/preview:opacity-100 transition-opacity flex items-center justify-center gap-3">
                    <button type="button" @click.stop="preview = ''; $refs.fileInput.value = ''" class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-lg transform hover:scale-110 transition-all">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="w-10 h-10 rounded-xl bg-white text-gray-800 flex items-center justify-center shadow-lg transform hover:scale-110 transition-all">
                        <i class="fas fa-sync-alt text-xs"></i>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
