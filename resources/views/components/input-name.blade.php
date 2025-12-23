@props(['value' => ''])
<div class="name-container">
    <input type="text" name="name" placeholder="Buscar..." value="{{ $value }}">
    <button type="submit">
        <i class="bi bi-search"></i>
    </button>
</div>

@vite(['resources/scss/components/input-name.scss'])