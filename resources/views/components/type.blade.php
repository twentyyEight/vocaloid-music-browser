@props([
'label',
'options' => [],
'value' => null,
])

<div>
    <label for="types">Tipo de {{ $label }}</label>

    <div>
        {{ $slot }}

        <select id="types">
            <option value=""></option>

            @if (is_array(reset($options)))

            @foreach ($options as $group => $items)
            @foreach ($items as $item_value => $item_label)
            <option
                value="{{ $item_value }}"
                data-type="{{ $group }}"
                {{ $value == $item_value ? 'selected' : '' }}>
                {{ $item_label }}
            </option>
            @endforeach
            @endforeach

            @else

            @foreach ($options as $option_value => $label)
            <option
                value="{{ $option_value }}"
                {{ $value == $option_value ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach

            @endif
        </select>
    </div>
</div>

<input type="hidden" name="type" id="type" value="{{ $value }}">