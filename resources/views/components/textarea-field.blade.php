@props(['name', 'label', 'value' => ''])

<div class="field-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="form-textarea"
    >{{ old($name, $value) }}</textarea>
    
    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>