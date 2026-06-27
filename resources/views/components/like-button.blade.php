@props(['item', 'likesCount', 'isLiked'])

<div class="item-detail__like-wrapper" data-item-id="{{ $item->id }}" data-url="{{ route('like.store', $item->id) }}">
    <button type="button" class="js-like-button" style="border:none; background:none;">
        <img src="{{ $isLiked ? asset('images/logo-heart-pink.png') : asset('images/logo-heart-default.png') }}"
            alt="いいね"
            class="js-like-icon {{ $isLiked ? 'is-liked' : '' }}"
            data-default="{{ asset('images/logo-heart-default.png') }}"
            data-pink="{{ asset('images/logo-heart-pink.png') }}">
        <span class="js-likes-count">{{ $likesCount }}</span>
    </button>
</div>