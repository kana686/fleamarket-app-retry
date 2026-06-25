<x-app-layout title="商品詳細画面">
    <div class="item-detail-container">
        <div class="item-image-area">
            <x-product-image :item="$item" class="large-image" />
        </div>

        <section class="item-detail-area">
            <div class="item-detail__header">
                <h1 class="item-detail__title">{{ $item->name }}</h1>
                <div class="item-detail__brand">{{ $item->brand_name }}</div>
                <div class="item-detail__price">{{ $item->price }}</div>

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
                <div class="item-detail__category">
                    <span class="item-detail__label">カテゴリー</span>
                    @foreach($item->categories as $category)
                        <span class="category-label">{{ $category->content }}</span>
                    @endforeach
                </div>

                <div class="item-detail__condition">
                    <span class="item-detail__label">商品の状態</span>
                    <span class="condition-label">{{ $item->condition->content }}</span>
            </div>

            <div class="item-detail__comments">
                <h2 class="item-detail__subtitle">コメント(1)</h2>

                <div class="item-detail__comment-list">
                @foreach($item->comments as $comment)
                    <div class="item-detail__comment">
                        <p class="comment-user">{{ $comment->user->name }}</p>
                        <p class="comment-body">{{ $comment->body }}</p>
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
