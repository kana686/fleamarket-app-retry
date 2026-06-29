@props(['name', 'label', 'labelClass', 'options', 'selected' => null, 'id' => null])

<div class="field-group">
    <label for="{{ $id ?? $name }}" class="field-label {{ $labelClass ?? '' }}">
        {{ $label }}
    </label>
    <select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-select">
        <option value="" hidden selected>選択してください</option>

        @foreach($options as $id => $labelName)
            <option
                value="{{ $id }}"
                {{ (old($name, $selected) == $id) ? 'selected' : '' }}
            >
                {{ $labelName }}
            </option>
        @endforeach
    </select>

    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>