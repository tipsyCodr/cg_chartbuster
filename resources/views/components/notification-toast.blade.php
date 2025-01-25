<div x-data="{ show: false, type: '', message: '' }" 
     x-init="
        @if(session('success'))
            show = true; type = 'success'; message = '{{ session('success') }}';
        @elseif(session('error'))
            show = true; type = 'error'; message = '{{ session('error') }}';
        @elseif(session('info'))
            show = true; type = 'info'; message = '{{ session('info') }}';
        @elseif(session('warning'))
            show = true; type = 'warning'; message = '{{ session('warning') }}';
        @endif
        if (show) setTimeout(() => show = false, 90000);
     "
     x-show="show"
     x-cloak
     class="fixed top-5 right-5 max-w-xs w-full p-4 rounded-lg shadow-lg text-white"
     :class="{
        'bg-green-500': type === 'success',
        'bg-red-500': type === 'error',
        'bg-blue-500': type === 'info',
        'bg-yellow-500': type === 'warning'
     }"
     x-transition style='z-index: 99999;'>
    <div class="flex justify-between items-start space-x-2" >
        <div class="flex flex-col">
            <div class="text-lg font-bold capitalize" x-text="type"></div>
            <span class="flex-1" x-text="message"></span>
        </div>
        <button @click="show = false" class="ml-4 text-xl leading-none hover:text-gray-300">&times;</button>
    </div>
</div>
