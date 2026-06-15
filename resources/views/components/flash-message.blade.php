@foreach (['success' => 'success', 'error' => 'error'] as $key => $type)
    @if (session($key))
        <div class="flash-message flash-message--{{ $type }}">
            {{ session($key) }}
        </div>
    @endif
@endforeach