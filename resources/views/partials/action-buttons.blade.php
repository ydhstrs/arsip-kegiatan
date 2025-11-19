<div class="flex space-x-2">
    <a href="{{ url('/dashboard/room/' . $room->id . '/edit') }}" class="btn btn-warning">Edit</a>
    <a href="{{ url('/dashboard/room/' . $room->id) }}" class="btn btn-info">Detail</a>
    <form action="{{ url('/dashboard/room/' . $room->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
