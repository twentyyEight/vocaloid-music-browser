@props([
'options' => [],
'value' => null,
])
<div>
    <label for="sort">Ordenar por</label>
    <select name="sort" id="sort">
        @foreach ($options as $option_value => $label)
        <option
            value="{{ $option_value }}"
            {{ $option_value == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
        @endforeach
    </select>
</div>