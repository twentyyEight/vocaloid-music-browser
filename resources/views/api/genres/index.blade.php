<div>
    @foreach ($genres as $genre)
    {{ $genre['name'] }}
    @endforeach
</div>

<ul class="pagination">

    {{-- Página anterior --}}
    <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
        <a class="page-link" href="?page={{ $page - 1 }}">«</a>
    </li>

    {{-- Números dinámicos --}}
    @for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++)
        <li class="page-item {{ $page == $i ? 'active' : '' }}">
        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
        </li>
        @endfor

        {{-- Página siguiente --}}
        <li class="page-item {{ $page == $pages ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $page + 1 }}">»</a>
        </li>

</ul>