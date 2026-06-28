document.addEventListener('DOMContentLoaded', () => {
    const likeButtons = document.querySelectorAll('.js-like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const wrapper = this.closest('.item-detail__like-wrapper');
            if (!wrapper) return;

            const icon = wrapper.querySelector('.js-like-icon');
            const countSpan = wrapper.querySelector('.js-likes-count');
            const url = wrapper.dataset.url;
            const isLiked = icon.classList.contains('is-liked');
            const method = isLiked ? 'delete' : 'post';

            axios({
                method: method,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => {
                const data = response.data;
                if (data.status === 'liked') {
                    icon.src = icon.dataset.pink;
                    icon.classList.add('is-liked');
                    countSpan.textContent = Number(countSpan.textContent) + 1;
                } else if (data.status === 'unliked') {
                    icon.src = icon.dataset.default;
                    icon.classList.remove('is-liked');
                    countSpan.textContent = Number(countSpan.textContent) - 1;
                }
            })
            .catch(error => {
                console.error('通信エラー:', error);

                if (error.response && error.response.status === 401) {
                    alert("いいね機能を使うには、ログインしてください");
                } else {
                    alert("エラーが発生しました。時間を置いてからもう一度お試しください");
                }
            });
        });
    });
});