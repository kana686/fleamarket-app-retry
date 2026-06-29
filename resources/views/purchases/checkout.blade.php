<x-app-layout title="商品購入画面">
    <div class="purchase-info-section">
        <div class="purchase-main-content">
            <div class="purchase-item-info">
                <x-product-image :item="$item" class="purchase-item-image" />

                <div class="item-details">
                    <h2 class="item-name">{{ $item->name }}</h2>
                    <p class="item-price">
                        <span class="price-symbol">¥</span>
                        <span class="price-value">{{ number_format($item->price) }}</span>
                    </p>
                </div>
            </div>

            <div class="purchase-payment-info">
                <x-select-field
                    id="payment-method-select"
                    name="payment_method"
                    label="支払い方法"
                    :options="$paymentMethods"
                    labelClass="payment-method-label"
                />
            </div>

            <div class="purchase-address-info">
                <div class="purchase-address-info__header">
                    <span class="purchase-address-info__title">配送先</span>
                    <a href="{{ route('address.edit', $item->id) }}"
                        class="purchase-address-info__change-link">
                        変更する
                    </a>
                </div>

                <div class="purchase-address-info__content">
                    <p>〒 {{ $user->post_code }}</p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $user->building }}</p>
                </div>
            </div>
        </div>

        <div class="purchase-summary-wrapper">
            <div class="purchase-summary">
                <div class="purchase-summary__row">
                    <span class="label">商品代金</span>
                    <span class="value">
                        <span class="price-symbol">¥</span>
                        <span class="price-value">{{ number_format($item->price) }}</span>
                    </span>
                </div>

                <div class="purchase-summary__row">
                    <span>支払い方法</span>
                    <span class="value" id="payment-method-display">
                        {{ $paymentMethods[$paymentMethod] ?? '未選択' }}
                    </span>
                </div>
            </div>

            <form action="{{ route('purchases.store', $item->id) }}" method="POST">
                @csrf

                <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                <input type="hidden" name="shipping_address" value="{{ $shippingAddress }}">

                <x-primary-button>購入する</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>