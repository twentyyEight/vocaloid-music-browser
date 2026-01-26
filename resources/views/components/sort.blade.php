@props([
'options' => [],
'value' => null,
])
<div>
    <label for="sort">Ordenar por</label>
    <select name="sort" id="sort">
        @foreach ($options as $option)
        <option
            value="{{ $option['value'] }}"
            {{ $value == $option['value'] ? 'selected' : '' }}>
            {{ $option['label'] }}
        </option>
        @endforeach
    </select>
</div>