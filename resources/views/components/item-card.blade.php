@props(['item'])

<div class="item-card" data-text="{{ $item->name }}">
    <a href="{{ route('items.show', $item->id) }}">
        <div class="card-image-wrap">
            <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
        </div>
        <div class="card-body">
            <h3 class="item-name" >{{ $item->name }}</h3>
        </div>
    </a>
</div>