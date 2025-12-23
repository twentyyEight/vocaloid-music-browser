@props(['page', 'pages'])
<ul class="pagination">

    <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
        <button type="button"
                class="page-link"
                data-page="1">
            Primera
        </button>
    </li>

    @for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++)
        <li class="page-item {{ $page == $i ? 'active' : '' }}">
            <button type="button"
                    class="page-link"
                    data-page="{{ $i }}">
                {{ $i }}
            </button>
        </li>
    @endfor

    <li class="page-item {{ $page == $pages ? 'disabled' : '' }}">
        <button type="button"
                class="page-link"
                data-page="{{ $pages }}">
            Última
        </button>
    </li>
</ul>
@push('styles')
@vite(['resources/scss/components/pagination.scss'])
@endpush