@foreach (['success' => 'green', 'error' => 'red'] as $key => $color)
    @if (session($key))
        <div class="bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-4 py-3 rounded mb-6">
            {{ session($key) }}
        </div>
    @endif
@endforeach