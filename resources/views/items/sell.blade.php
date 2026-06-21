<x-app-layout>
    <x-slot name="title">商品出品画面</x-slot>

    <div class="item-sell-container">
        <h1>商品の出品</h1>

        <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <section class="sell-section">
                <x-sell-image-upload />
            </section>

            <section class="sell-section">
                <h2>商品の詳細</h2>
                <x-category-selector :categories="$categories" />
                <x-select-field name="condition_id" label="商品の状態" :options="$conditions" />
            </section>

            <section class="sell-section">
                <h2>商品名と説明</h2>
                <x-input-field name="name" label="商品名" type="text" />
                <x-input-field name="brand_name" label="ブランド名" type="text" />
                <x-textarea-field name="description" label="商品の説明" />
                <x-input-field name="price" label="販売価格" type="text" />
            </section>

            <x-primary-button>出品する</x-primary-button>
        </form>
    </div>
</x-app-layout>