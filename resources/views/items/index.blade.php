<x-app-layout title="商品一覧">
    <div class="items-container">
        <div class="tabs">
            <x-tab name="recommend" routeName="items.index">おすすめ</x-tab>
            <x-tab name="mylist" routeName="items.index">マイリスト</x-tab>
        </div>

        <div class="item-grid">
            @forelse ($items as $item)
                <x-item-card :item="$item" />
            @empty
                <p>商品がありません。</p>
            @endforelse
        </div>
    </div>
</x-app-layout>