@props([
'id',
'entity',
'isFavorite' => false,
])

@auth
@if (!$isFavorite)
<form action="{{ route($entity . '.store', $id) }}" method="POST">
    @csrf
    <button type="submit" class="fav">
        Agregar a favoritos
        <i class="bi bi-heart-fill"></i>
    </button>
</form>
@else
<form action="{{ route($entity . '.delete', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="delete-fav">
        Eliminar de favoritos
        <i class="bi bi-heartbreak-fill"></i>
    </button>
</form>
@endif
@endauth