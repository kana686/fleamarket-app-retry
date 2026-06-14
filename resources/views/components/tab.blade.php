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

    $isActive = request('tab') === $name || ($name === 'recommend' && empty(request('tab')));
@endphp

<a href="{{ $url }}" class="tab-link {{ $isActive ? 'active' : '' }}">
    {{ $slot }}
</a>