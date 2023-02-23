@extends('dashboard.layouts.main')
@section('container')
    <div class="section">
        <div class="section-header">
            <h1>Edit Book Page</h1>
        </div>
        <div class="section-body">
            <div class="col-lg-12">
                <form method="post" action="{{ route('book.update', $book->id) }}}}" class="mb-5">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="call_number" class="form-label">Book Call Number</label>
                                <input type="text" class="form-control @error('call_number') is-invalid @enderror" id="call_number"
                                    name="call_number" value="{{ old('call_number', $book->call_number) }}" required autofocus>
                                @error('call_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Book Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title', $book->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="copy" class="form-label">Number of Copies</label>
                                <input type="number" min="1" class="form-control @error('copy') is-invalid @enderror" id="copy"
                                    name="copy" value="{{ old('copy', $book->copy) }}" required>
                                @error('copy')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="publish_place" class="form-label">Publish Place</label>
                                <input type="text" class="form-control @error('publish_place') is-invalid @enderror" id="publish_place"
                                    name="publish_place" value="{{ old('publish_place', $book->publish_place) }}" required>
                                @error('publish_place')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher"
                                    name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                                @error('publisher')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="isbn_issn" class="form-label">ISBN/ISSN</label>
                                <input type="text" class="form-control @error('isbn_issn') is-invalid @enderror" id="isbn_issn"
                                    name="isbn_issn" value="{{ old('isbn_issn', $book->isbn_issn) }}" required>
                                @error('isbn_issn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-lg-12">
                            <a href="{{ route('book.index') }}" class="btn btn-success text-decoration-none mr-2">
                                <span data-feather="arrow-left"></span> Back
                            </a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
