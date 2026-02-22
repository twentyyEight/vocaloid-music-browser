@props(['name','label','value' => []])
<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="input-tags-container">
        <input type="text" id="{{ $name }}">
        <x-antdesign-loading-3-quarters-o class="loading {{ $name }}" />
    </div>

    <input type="hidden" id="{{ $name }}_ids" value='@json($value)'>

    <div class="selected_tags {{ $name }}"></div>
</div>