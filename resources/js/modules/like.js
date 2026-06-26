export function initLikeButton() {
    const likeBtn = document.querySelector('.js-like-icon');
    if (!likeBtn) return;

    likeBtn.addEventListener('click', () => {
        const itemId = likeBtn.dataset.itemId;
        likeBtn.classList.toggle('is-liked');
        
        console.log(`商品ID ${itemId} のいいねを切り替え`);
    });
}