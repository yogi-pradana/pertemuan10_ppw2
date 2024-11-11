@extends('auth.layouts')
@section('content')
<form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 row">
        <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="title" name="title">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
        <div class="col-md-6">
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="picture" class="col-md-4 col-form-label text-md-end">Picture</label>
        <div class="col-md-6">
            <input type="file" class="form-control" id="picture" name="picture" value="{{ old('picture') }}">
            @error('picture')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
</form>
@endsection
