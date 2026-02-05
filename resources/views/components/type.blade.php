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

            @foreach ($options as $option)
            <option
                value="{{ $option['value'] }}"
                {{ $value == $option['value'] ? 'selected' : '' }}

                @if (!empty($option['data']))
                data-type="{{ $option['data'] }}"
                @endif>
                {{ $option['label'] }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<input type="hidden" name="type" id="type" value="{{ $value }}">