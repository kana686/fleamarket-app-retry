@props(['action'])
<div class="search-wrapper">
    <form action="{{ $action }}" method="GET">
        <input 
            type="text" 
            name="keyword" 
            placeholder="なにをお探しですか？" 
            value="{{ request()->query('keyword') }}"
            class="search-input"
        >
    </form>
</div>