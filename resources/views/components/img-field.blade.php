@props(['src', 'alt' => 'プロフィール画像'])

<div class="image-wrapper">
    @if($src)
        <img id="profile-image-preview"
            src="{{ asset('storage/' . $src) }}"
            alt="{{ $alt }}"
            {{ $attributes->merge(['class' => 'rounded-circle']) }}>
    @else
        <div id="profile-image-preview"
            {{ $attributes->merge(['class' => 'rounded-circle profile-img bg-gray']) }}></div>
    @endif
</div>