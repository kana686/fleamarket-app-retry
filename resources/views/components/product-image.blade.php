@props(['item', 'class' => 'default-size'])

<div class="product-image-container {{ $class }}">
    <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
</div>