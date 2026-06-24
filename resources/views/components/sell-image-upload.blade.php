<div class="sell-image-container">
    <p class="section-label">商品画像</p>

    <label class="sell-image-upload-area">
        <img id="sell-image-preview" class="preview-image" src="#" alt="プレビュー" style="display:none;">
        <x-file-upload-button name="img_url" id="sell-image-input" />
    </label>

    @error('img_url')
        <span class="error-message">{{ $message }}</span>
    @enderror

    @if($errors->any() && !$errors->has('img_url'))
        <p class="retry-message">
            ※画像ファイルを再度選択してください
        </p>
    @endif
</div>