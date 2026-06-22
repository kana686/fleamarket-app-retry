@props(['name', 'label', 'options', 'selected' => null])

<div class="field-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
        <option value="">選択してください</option>
        
        @foreach($options as $option)
            <option 
                value="{{ $option->id }}" 
                {{ (old($name, $selected) == $option->id) ? 'selected' : '' }}
            >
                {{ $option->content }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>