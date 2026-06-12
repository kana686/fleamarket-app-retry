@props(['name', 'routeName'])

@php
    $keyword = request('keyword');
    $currentTab = request('tab', 'recommend');
    $url = route($routeName, ['tab' => $name, 'keyword' => $keyword]);
@endphp

<a href="{{ $url }}" 
   class="tab-link {{ request('tab') === $name ? 'active' : '' }}">
    {{ $slot }}
</a>