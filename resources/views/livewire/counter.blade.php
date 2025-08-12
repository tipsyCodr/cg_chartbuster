<div style="text-align: center">

    <button wire:click="increment">+</button>

    <h1>{{ $count }}</h1>

    <input wire:model.live="message" type="text">
    <h1>MEsage: {{ $message }}</h1>
</div>
