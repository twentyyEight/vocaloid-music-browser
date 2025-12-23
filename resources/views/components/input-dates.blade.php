@props(['value_before' => '', 'value_after' => ''])
<div class="date-container">
    <label for="beforeDate">Publicada antes de:</label>
    <input type="date" name="beforeDate" id="beforeDate" value="{{ request('beforeDate') }}" class="date">
</div>

<div class="date-container">
    <label for="afterDate">Publicada después de:</label>
    <input type="date" name="afterDate" id="afterDate" value="{{ request('afterDate') }}" class="date">
</div>
@vite(['resources/scss/components/input-dates.scss'])