@props(['page', 'pages'])
<ul class="pagination" id="pagination">

    <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
        <a class="page-link" href="?page=1">«« Primera</a>
    </li>

    @for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++)
        <li class="page-item {{ $page == $i ? 'active' : '' }}">
        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
        </li>
        @endfor

        <li class="page-item {{ $page == $pages ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $pages }}">Última »»</a>
        </li>

</ul>