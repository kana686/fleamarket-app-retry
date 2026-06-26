<x-app-layout title="商品詳細画面">
    <div class="item-detail-container">
        <div class="item-image-area">
            <x-product-image :item="$item" class="large-image" />
        </div>

        <section class="item-detail-area">
            <div class="item-detail__header">
                <h1 class="item-detail__title">{{ $item->name }}</h1>
                <div class="item-detail__brand">{{ $item->brand_name }}</div>
                <div class="item-detail__price">
                    <span class="price-symbol">¥</span>
                    <span class="price-value">{{ number_format($item->price) }}</span>
                </div>

                <div class="item-detail__actions">
                    <x-like-button :item="$item" :likesCount="$item->mylists_count" />
                    <x-comment-count :commentsCount="$item->comments_count" />
                </div>
            </div>

            <div class="item-detail__purchase">
                <a href="{{ route('purchases.checkout', ['item' => $item->id]) }}"
                    class="item-detail__purchase-btn">
                    購入手続きへ
                </a>
            </div>

            <div class="item-detail__description">
                <h2 class="item-detail__subtitle">商品説明</h2>
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-detail__info">
                <h2 class="item-detail__subtitle">商品の情報</h2>
                <div class="item-detail__info-grid">
                    <span class="item-detail__label">カテゴリー</span>
                    <div class="item-detail__values">
                        @foreach($item->categories as $category)
                            <span class="category-label">{{ $category->content }}</span>
                        @endforeach
                    </div>

                    <span class="item-detail__label">商品の状態</span>
                    <div class="item-detail__value">
                        <span class="condition-label">{{ $item->condition->content }}</span>
                    </div>
                </div>
            </div>

            <div class="item-detail__comments">
                <h2 class="item-detail__subtitle">コメント({{ $item->comments_count }})</h2>

                <div class="item-detail__comment-list">
                @foreach($item->comments as $comment)
                    <div class="item-detail__comment">
                        <div class="comment-user-info">
                            <x-img-field
                                :src="$comment->user->profile_image_path"
                                alt="{{ $comment->user->name }}のプロフィール画像"
                                class="profile-img-small" />
                            <span class="comment-user">{{ $comment->user->name }}</span>
                        </div>
                        <p class="comment-body">{{ $comment->content }}</p>
                    </div>
                @endforeach
                </div>

                <form action="{{ route('purchases.checkout', ['item' => $item->id]) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                    <x-textarea-field name="content" label="商品へのコメント" />
                    <x-primary-button>コメントを送信する</x-primary-button>
                </form>
            </div>
        </section>
    </div>
</x-app-layout>
