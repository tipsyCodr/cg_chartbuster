<div>
    <textarea {{ $attributes }}id="description" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black p-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
    @error('description')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror
</div>