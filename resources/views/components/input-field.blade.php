@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'icon' => null, 'id' => null])

<div class="form-group">
    @if(isset($label))
        <label>{{ $label }}</label>
    @endif

    <div class="input-wrapper">
        @if($icon)
            <span class="input-icon">{{ $icon }}</span>
        @endif
        <input type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            class="form-control {{ $icon ? 'has-icon' : '' }} @error($name) is-invalid @enderror"
            value="{{ old($name, $value) }}">
    </div>

    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>