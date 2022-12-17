@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Tambah Buku</h1>
    </div>
    <div class="col-lg-8">
        <form method="post" action="/dashboard/buku" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul"
                value="{{ old('judul') }}" required autofocus>
                @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                value="{{ old('slug') }}" readonly required>
                @error('slug')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" name="category_id">
                    @foreach ($categories as $category)
                    @if (old('category_id') == $category->id)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Post Image</label>
                <img class="imagePreview img-fluid mb-3 col-sm-5">
                <input type="file" name="image" id="image" class="form-control 
                    @error('image') is-invalid @enderror" onchange="imagePreview()">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Body</label>
                <input id="desc" type="hidden" name="desc" value="{{ old('desc') }}">
                <trix-editor input="desc"></trix-editor>
                @error('desc')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tambah Buku</button>
        </form>
    </div>

    <script>
        const judul = document.querySelector('#judul');
        const slug = document.querySelector('#slug');

        judul.addEventListener('change', function() {
            fetch('/dashboard/buku/cekSlug?title=' + judul.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });

        function imagePreview(){
            const image = document.querySelector('#image');
            const imagePreview = document.querySelector('.imagePreview');

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent){
                imagePreview.src = oFREvent.target.result;
            }

        }
    </script>
@endsection
