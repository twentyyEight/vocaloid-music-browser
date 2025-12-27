@props(['name','label','value' => []])
<div>
    <div id="tag-container">
        <label for="{{ $name }}">{{ $label }}</label>
        <div id="input-container">
            <input type="text" id="{{ $name }}">
            <x-antdesign-loading-3-quarters-o id="loading_{{ $name }}" class="loading" style="display: none;" />
        </div>
    </div>

    <input type="hidden" id="{{ $name }}_ids" value='@json($value)'>

    <div id="selected_{{ $name }}" class="selected_tags"></div>
</div>