@extends('auth.layouts')
@section('content')
<form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3 row">
        <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $gallery->title) }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
        <div class="col-md-6">
            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $gallery->description) }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="picture" class="col-md-4 col-form-label text-md-end">Picture</label>
        <div class="col-md-6">
            <input type="file" class="form-control" id="picture" name="picture">
            @error('picture')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="current_image" class="col-md-4 col-form-label text-md-end">Current Image</label>
        <div class="col-md-6">
            <img src="{{ asset('storage/images/'.$gallery->picture) }}" alt="Current Image" class="img-fluid" style="max-width: 200px;">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
