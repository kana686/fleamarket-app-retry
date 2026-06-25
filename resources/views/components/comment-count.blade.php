@props(['commentsCount'])

<div class="item-detail__comment-wrapper js-comment-scroll-btn">
    <img src="{{ asset('images/logo-speech-bubble.png') }}" alt="コメント">
    <span>{{ $commentsCount }}</span>
</div>