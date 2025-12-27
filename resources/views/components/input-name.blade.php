@props(['value' => ''])
<div id="name-container">
    <input type="text" name="name" placeholder="Buscar por nombre..." value="{{ $value }}">
    <button type="submit">
        <i class="bi bi-search"></i>
    </button>
</div>