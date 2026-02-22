@props([
    'page' => 1,
    'entity'
])

<form action="{{ route($entity . '.index') }}" method="GET" class="filters">

    <div class="controls">
        <x-input-name :value="request('name', '')" />
        <button type="button" data-bs-toggle="modal" data-bs-target="#filters_modal" class="open_filters">
            Filtros
            <i class="bi bi-funnel-fill"></i>
        </button>
    </div>

    <div class="modal fade" id="filters_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Filtros</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer">
                    <button type="submit" class="apply_filters">Aplicar filtros</button>
                    <a href="{{ route($entity . '.index') }}" class="reset_filters">Limpiar filtros</a>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>