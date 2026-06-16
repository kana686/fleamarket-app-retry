@props(['src', 'alt' => 'プロフィール画像'])

<div class="image-wrapper">
    <img src="{{ $src ? asset('storage/' . $src) : asset('images/default-avatar.png') }}" 
         alt="{{ $alt }}" 
         {{ $attributes->merge(['class' => 'rounded-circle']) }}>
</div>