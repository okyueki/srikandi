<a href="{{ route('inventaris.show', $row->no_inventaris) }}" class="btn btn-info btn-sm">View</a>
<a href="{{ route('inventaris.edit', $row->no_inventaris) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('inventaris.destroy', $row->no_inventaris) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>
