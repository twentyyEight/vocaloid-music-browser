@props(['value' => ''])
<div class="name-container">
    <input type="text" name="name" placeholder="Buscar por nombre..." value="{{ $value }}">
    <x-antdesign-loading-3-quarters-o class="loading name" />
    <button type="submit">
        <i class="bi bi-search"></i>
    </button>
</div>