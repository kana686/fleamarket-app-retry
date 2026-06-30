<x-app-layout>
    <x-slot name="title">送付先住所変更画面</x-slot>

    <div class="shipping-address-edit-container">
        <h1 class="shipping-address-edit__title">住所の変更</h1>

        <form action="{{ route('purchases.address.update', $item->id) }}" method="POST" novalidate>
        @csrf
        @method('PATCH')

        <x-input-field
            name="post_code"
            label="郵便番号"
            value="{{ old('post_code', $address->post_code) }}"
        />

        <x-input-field
            name="address"
            label="住所"
            value="{{ old('address', $address->address) }}"
        />

        <x-input-field
            name="building"
            label="建物名"
            value="{{ old('building', $address->building) }}"
        />

            <x-primary-button>更新する</x-primary-button>
        </form>
    </div>
</x-app-layout>