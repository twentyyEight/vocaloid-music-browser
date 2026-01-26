@props([
'id',
'entity',
'isFavorite' => false,
])

@auth
@if (!$isFavorite)
<form action="{{ route($entity . '.store', $id) }}" method="POST" class="fav">
    @csrf
    <button type="submit">
        Agregar a favoritos
        <i class="bi bi-heart-fill"></i>
    </button>
</form>
@else
<form action="{{ route($entity . '.delete', $id) }}" method="POST" class="delete-fav">
    @csrf
    @method('DELETE')
    <button type="submit">
        Eliminar de favoritos
        <i class="bi bi-heartbreak-fill"></i>
    </button>
</form>
@endif
@endauth