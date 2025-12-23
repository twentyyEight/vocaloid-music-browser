@props(['name','label','value' => []])
<div>
    <div id="tag-container">
        <label for="{{ $name }}">{{ $label }}</label>
        <input type="text" id="{{ $name }}">
    </div>
    <p style="display: none;" id="loading_{{ $name }}">Buscando...</p>

    <input type="hidden" id="{{ $name }}_ids" value='@json($value)'>

    <div id="selected_{{ $name }}"></div>
</div>
@vite(['resources/scss/components/tags.scss'])