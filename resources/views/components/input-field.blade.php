<div class="form-group">
    @if(isset($label))
        <label>{{ $label }}</label>
    @endif

    <input type="{{ $type ?? 'text' }}" 
           name="{{ $name }}" 
           class="form-control @error($name) is-invalid @enderror" 
           value="{{ old($name, $value ?? '') }}">

    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>