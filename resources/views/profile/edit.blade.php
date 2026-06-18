<x-app-layout>
    <x-slot name="title">プロフィール設定</x-slot>

    <div class="profile-edit-container">
        <h1>プロフィール設定</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')

        <div class="profile-image-section">
            <x-img-field :src="$user->img_url" />
            <x-file-upload-button accept="image/*" />
        </div>

            @foreach ($fields as $field)
                <x-input-field 
                    name="{{ $field['name'] }}" 
                    label="{{ $field['label'] }}" 
                    type="text" 
                    value="{{ old($field['name'], $field['value'] ?? '') }}"
                />
            @endforeach

            <x-primary-button>更新する</x-primary-button>
        </form>
    </div>
</x-app-layout>