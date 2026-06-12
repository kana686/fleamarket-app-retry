@props(['name', 'routeName'])

@php
    $keyword = request('keyword');
    $params = ['tab' => $name, 'keyword' => $keyword];

    if ($name === 'recommend') {
        unset($params['tab']);
    }

    if (empty($keyword)) {
        unset($params['keyword']);
    }
    
    $url = route($routeName, $params);
@endphp

<a href="{{ $url }}" 
   class="tab-link {{ request('tab') === $name ? 'active' : '' }}">
    {{ $slot }}
</a>