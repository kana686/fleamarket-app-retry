<x-app-layout title="商品一覧">
    <div class="tabs-wrapper">
        <div class="tabs">
            <x-tab name="recommend" routeName="items.index">おすすめ</x-tab>
            <x-tab name="mylist" routeName="items.index">マイリスト</x-tab>
        </div>
    </div>

    <div class="items-container">
        <div class="item-grid">
            @if(request('tab') === 'mylist' && auth()->guest())
                <div class="alert-message">
                    マイリスト機能を使用するにはログインが必要です。<br>
                    <a href="{{ route('login.create') }}">ログインはこちら</a>
                </div>
            @else
                @forelse ($items as $item)
                    <x-item-card :item="$item" />
                @empty
                    <p>商品がありません。</p>
                @endforelse
            @endif
        </div>
    </div>
</x-app-layout>