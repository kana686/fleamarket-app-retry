@props(['item', 'likesCount', 'isLiked'])

<div class="item-detail__like-wrapper" data-item-id="{{ $item->id }}">
    <button type="button" class="js-like-button" style="border:none; background:none;">
        <img src="{{ $isLiked ? asset('images/logo-heart-pink.png') : asset('images/logo-heart-default.png') }}"
            alt="いいね"
            class="js-like-icon"
            data-default="{{ asset('images/logo-heart-default.png') }}"
            data-pink="{{ asset('images/logo-heart-pink.png') }}">
    </button>

    <span class="js-likes-count">{{ $likesCount }}</span>
</div>