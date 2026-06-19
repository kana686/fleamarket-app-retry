<x-app-layout title="プロフィール">
    <div class="profile-section">
        <x-img-field :src="$user->img_url" />

        <div class="profile-info">
            <h1 class="user-name">{{ $user->name }}</h1>
            <a href="{{ route('profile.edit') }}" class="btn-edit">プロフィールを編集</a>
        </div>
    </div>

    <div class="tabs-wrapper">
        <div class="tabs">
            <x-tab name="sell" routeName="mypage" defaultName="sell">出品した商品</x-tab>
            <x-tab name="buy" routeName="mypage" defaultName="sell">購入した商品</x-tab>
        </div>
    </div>

    <div class="items-container">
        <div class="item-grid">
            @forelse ($items as $item)
                <x-item-card :item="$item" />
            @empty
                <p>商品がありません。</p>
            @endforelse
        </div>
    </div>
</x-app-layout>