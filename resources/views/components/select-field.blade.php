@props(['name', 'label', 'options', 'selected' => null])

<div class="field-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
        <option value="" hidden selected>選択してください</option>

        @foreach($options as $id => $labelName)
            <option
                value="{{ $id }}"
                {{ (old($name, $selected) == $option->id) ? 'selected' : '' }}
            >
                {{ $labelName }}
            </option>
        @endforeach
    </select>

    @error($name)
        <span class="error-message">{{ $message }}</span>
    @enderror
</div>