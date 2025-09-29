@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle . $title :  $title)

@section('content')
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <a href="{{ route('struktur_organisasi.create') }}" class="btn btn-success waves-effect waves-light mb-3">Create Struktur Organisasi</a>
                        
                        @if ($message = Session::get('success'))
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: '{{ $message }}',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            </script>
                        @endif
                        <div class="list-group">
        @foreach($hierarchy as $item)
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-1">{{ $item->pegawai->nama }}
                        <small class="text-muted">({{ $item->pegawai->jbtn }})</small>
                    </h5>
                    
                    <div>
                        <a href="{{ route('struktur_organisasi.edit', $item->id_struktur_organisasi) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('struktur_organisasi.destroy', $item->id_struktur_organisasi) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </form>
                    </div>
                </div>

                @if(isset($item->children) && count($item->children))
                    <div class="sub-list mt-2">
                        @foreach($item->children as $child)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $child->pegawai->nama }}
                                    <small class="text-muted">({{ $child->pegawai->jbtn }})</small>
                                    </h6>
                                    <div>
                                        <a href="{{ route('struktur_organisasi.edit', $child->id_struktur_organisasi) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('struktur_organisasi.destroy', $child->id_struktur_organisasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>

                                @if(isset($child->children) && count($child->children))
                                    <div class="sub-list mt-2">
                                        @foreach($child->children as $grandChild)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $grandChild->pegawai->nama }}
                                                        <small class="text-muted">({{ $grandChild->pegawai->jbtn }})</small>
                                                    </span>
                                                    <div>
                                                        <a href="{{ route('struktur_organisasi.edit', $grandChild->id_struktur_organisasi) }}" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('struktur_organisasi.destroy', $grandChild->id_struktur_organisasi) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </div>

                                                @if(isset($grandChild->children) && count($grandChild->children))
                                                    <div class="sub-list mt-2">
                                                        @foreach($grandChild->children as $greatGrandChild)
                                                            <div class="list-group-item">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <span>{{ $greatGrandChild->pegawai->nama }}
                                                                        <small class="text-muted">({{ $greatGrandChild->pegawai->jbtn }})</small>
                                                                    </span>
                                                                    <div>
                                                                        <a href="{{ route('struktur_organisasi.edit', $greatGrandChild->id_struktur_organisasi) }}" class="btn btn-warning btn-sm" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="{{ route('struktur_organisasi.destroy', $greatGrandChild->id_struktur_organisasi) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                                <i class="fas fa-trash"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                             @if(isset($greatGrandChild->children) && count($greatGrandChild->children))
                                                                <div class="sub-list mt-2">
                                                                    @foreach($greatGrandChild->children as $greatGreatGrandChild)
                                                                        <div class="list-group-item">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <span>{{ $greatGreatGrandChild->pegawai->nama }}
                                                                                    <small class="text-muted">({{ $greatGreatGrandChild->pegawai->jbtn }})</small>
                                                                                </span>
                                                                                <div>
                                                                                    <a href="{{ route('struktur_organisasi.edit', $greatGrandChild->id_struktur_organisasi) }}" class="btn btn-warning btn-sm" title="Edit">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </a>
                                                                                    <form action="{{ route('struktur_organisasi.destroy', $greatGrandChild->id_struktur_organisasi) }}" method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <a href="#" class="btn btn-danger btn-sm delete-btn" title="Hapus">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @endforeach
                                                                     </div>
                                                                 @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <script>
     document.addEventListener('DOMContentLoaded', function () {
        // Attach event listeners to all delete buttons
        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default anchor click behavior
                
                const form = this.closest('form'); // Find the closest form element

                // Check if the form exists
                if (!form) {
                    console.error('Form not found!');
                    return;
                }

                // Display the SweetAlert confirmation
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });
</script>

@endsection