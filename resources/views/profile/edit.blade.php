<x-app-layout>
    <x-slot name="title">プロフィール設定</x-slot>

    <div class="profile-edit-container">
    <h1>プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PATCH')

    {{-- ここに画像のコンポーネントを入れる --}}

    @php
        $fields = [
            ['name' => 'name',      'label' => 'ユーザー名', 'value' => $user->name, 'extra' => []],
            ['name' => 'post_code', 'label' => '郵便番号',  'value' => $user->post_code, 'extra' => ['inputmode' => 'numeric']],
            ['name' => 'address',   'label' => '住所',      'value' => $user->address, 'extra' => []],
            ['name' => 'building',  'label' => '建物名',    'value' => $user->building, 'extra' => []],
        ];
    @endphp


        @foreach ($fields as $field)
            <x-input-field 
                name="{{ $field['name'] }}" 
                label="{{ $field['label'] }}" 
                type="text" 
                value="{{ old($field['name'], $field['value']) }}"
                @foreach($field['extra'] as $attr => $value)
                    {{ $attr }}="{{ $value }}"
                @endforeach
            />
        @endforeach

        <x-primary-button>更新する</x-primary-button>
    </form>

</x-app-layout>