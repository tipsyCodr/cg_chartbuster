@props([
    'headers' => [],
    'hasStickyHeader' => true,
    'hasHover' => true,
    'hasZebra' => true,
    'hasBorder' => true,
    'responsive' => true,
])

<div class="{{ $responsive ? 'overflow-x-auto overflow-y-hidden' : '' }} {{ $hasBorder ? 'border border-gray-100 rounded-2xl' : '' }}">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse']) }}>
        <thead class="{{ $hasStickyHeader ? 'sticky top-0 z-10' : '' }} bg-gray-50/80 backdrop-blur-md">
            <tr class="border-b border-gray-100 uppercase text-[10px] font-black text-gray-400 tracking-widest">
                @foreach($headers as $header)
                    <th @class([
                        'px-6 py-4 font-black',
                        'text-right' => $header['align'] ?? '' === 'right',
                        'text-center' => $header['align'] ?? '' === 'center',
                    ])>
                        {{ is_string($header) ? $header : ($header['label'] ?? '') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody @class([
            'divide-y divide-gray-100' => $hasBorder,
            'divide-y divide-gray-50' => !$hasBorder,
        ])>
            {{ $slot }}
        </tbody>
    </table>
</div>
