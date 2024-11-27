@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Gallery</div>
            <div class="card-body">
                <div class="row" id="gallery">
                    @if(count($galleries) > 0)
                        @foreach($galleries as $gallery)
                        <div class="col-sm-2">
                            <div>
                                <a class="example-image-link" href="{{ asset('storage/images/'.$gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                    <img class="example-image img-fluid mb-2" src="{{ asset('storage/images/'.$gallery->picture) }}" alt="image-{{ $gallery->id }}">
                                </a>
                            </div>
                            <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm mt-2">Edit</a>
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">Delete</button>
                            </form>
                        </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data</h3>
                    @endif
                </div>
                <div class="d-flex">
                    {{ $galleries->links() }}
                </div>
                <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm mt-3">Upload Gambar</a>
            </div>
        </div>
    </div>              
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" 
        integrity="sha256-oKhay81EqWp4NKx4vKFCFn3+qoOVtJn3QNZTCiWLP4=" 
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        // Fetch data from the API
        $.get("http://127.0.0.1:8000/api/gallery", function (response) {
            if (response.gallery && response.gallery.length > 0) {
                let html = '';
                response.gallery.forEach(function (gallery) {
                    html += `
                        <div class="col-sm-2">
                            <div>
                                <a class="example-image-link" 
                                   href="/storage/images/${gallery.picture}" 
                                   data-lightbox="roadtrip" 
                                   data-title="${gallery.description}">
                                    <img class="example-image img-fluid mb-2" 
                                         src="/storage/images/${gallery.picture}" 
                                         alt="${gallery.title}">
                                </a>
                            </div>
                            <button class="btn btn-warning btn-sm mt-2" disabled>Edit</button>
                            <button class="btn btn-danger btn-sm mt-2" disabled>Delete</button>
                        </div>
                    `;
                });
                $('#gallery').html(html);
            } else {
                $('#gallery').html('<h3>Tidak ada data.</h3>');
            }
        }).fail(function () {
            $('#gallery').html('<h3>Gagal memuat data dari API.</h3>');
        });
    });
</script>
@endsection
