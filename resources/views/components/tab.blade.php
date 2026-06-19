@props(['name', 'routeName', 'defaultName' => 'recommend'])

@php
    $keyword = request('keyword');
    
    $params = ['keyword' => $keyword];
    if ($name !== 'recommend') {
        $params['tab'] = $name;
    }
    
    $params = array_filter($params);
    $url = route($routeName, $params);

    $tab = request('tab');
    $isActive = ($tab === $name) || (empty($tab) && $name === $defaultName);
@endphp

<a href="{{ $url }}" class="tab-link {{ $isActive ? 'active' : '' }}">
    {{ $slot }}
</a>