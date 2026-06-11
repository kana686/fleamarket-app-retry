@props(['item'])

<div class="item-card">
    <a href="{{ route('items.show', $item->id) }}">
        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
        <div class="item-name">{{ $item->name }}</div>
    </a>
</div>