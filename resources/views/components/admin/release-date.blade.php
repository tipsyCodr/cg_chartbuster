@props([
    'name' => 'release_date',
    'yearOnlyName' => 'is_release_year_only',
    'value' => null,
    'yearOnlyValue' => false,
    'label' => 'Show Year Only',
    'error' => null,
])

@php
    $isYearOnly = (bool) $yearOnlyValue;
    $dateVal = $value ?? '';
@endphp

<div x-data="{
    yearOnly: {{ $isYearOnly ? 'true' : 'false' }},
    dateVal: @js($dateVal),
    get displayYear() {
        if (!this.dateVal) return '';
        return String(this.dateVal).includes('-') ? String(this.dateVal).split('-')[0] : this.dateVal;
    },
    get submittedValue() {
        if (!this.dateVal) return '';
        if (!this.yearOnly) {
            return this.dateVal;
        }

        const year = String(this.displayYear).trim();
        return /^\\d{4}$/.test(year) ? `${year}-01-01` : '';
    }
}" class="space-y-3">

    <input type="hidden" name="{{ $name }}" :value="submittedValue">

    {{-- Full Date Input --}}
    <input
        x-show="!yearOnly"
        type="date"
        x-model="dateVal"
        @class([
            'w-full p-3 rounded-xl border bg-gray-50/50 text-sm font-bold text-gray-700 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/30 transition-all shadow-inner',
            'border-rose-300 focus:ring-rose-500/10' => $error,
            'border-gray-100' => !$error,
        ])
    >

    {{-- Year-Only Input --}}
    <input
        x-show="yearOnly"
        type="number"
        min="1900"
        max="2100"
        placeholder="YYYY"
        :value="displayYear"
        @input="dateVal = $event.target.value"
        @class([
            'w-full p-3 rounded-xl border bg-gray-50/50 text-sm font-bold text-gray-700 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/30 transition-all shadow-inner',
            'border-rose-300 focus:ring-rose-500/10' => $error,
            'border-gray-100' => !$error,
        ])
    >

    {{-- Toggle Checkbox --}}
    <label class="flex items-center gap-2 cursor-pointer group select-none">
        <input
            type="checkbox"
            name="{{ $yearOnlyName }}"
            value="1"
            x-model="yearOnly"
            class="w-4 h-4 rounded border-gray-200 text-blue-600 focus:ring-blue-500/20 cursor-pointer"
        >
        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-gray-600 transition-colors">
            {{ $label }}
        </span>
    </label>

    @if($error)
        <p class="mt-1 text-xs font-bold text-rose-500">{{ $error }}</p>
    @endif
</div>
