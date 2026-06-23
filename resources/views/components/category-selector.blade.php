@props(['categories'])

<div class="field-group">
    <label class="section-label">カテゴリー</label>

    @error('categories')
        <span class="error-message">{{ $message }}</span>
    @enderror

    <div class="category-wrapper">
        @foreach($categories as $category)
            <input
                type="checkbox"
                id="cat-{{ $category->id }}"
                name="categories[]"
                value="{{ $category->id }}"
                class="category-input"
            >
            <label for="cat-{{ $category->id }}" class="category-label">
                {{ $category->content }}
            </label>
        @endforeach
    </div>
</div>