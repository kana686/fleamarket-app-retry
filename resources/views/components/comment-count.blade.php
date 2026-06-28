@props(['commentsCount'])

<a href="#comments-section" class="item-detail__comment-wrapper">
    <img src="{{ asset('images/logo-speech-bubble.png') }}" alt="コメント">
    <span>{{ $commentsCount }}</span>
</a>