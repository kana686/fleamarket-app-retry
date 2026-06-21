@props(['categories'])

<div class="field-group">
    <label class="section-label">カテゴリー</label>
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
                {{ $category->name }}
            </label>
        @endforeach
    </div>
</div>