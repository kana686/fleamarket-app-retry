@props(['item', 'likesCount'])

<div class="item-detail__like-wrapper">
    <img src="{{ asset('images/logo-heart-default.png') }}"
        alt="いいね"
        class="js-like-icon"
        data-default="{{ asset('images/logo-heart-default.png') }}"
        data-pink="{{ asset('images/logo-heart-pink.png') }}">

    <span>{{ $likesCount }}</span>
</div>