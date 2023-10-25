@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product Details
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Shirup Marjan</h2>
                <p class="dashboard-subtitle">Product Details</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('dashboard-product-update', $product->slug) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text"
                                                    class="form-control @error('price') is-invalid @enderror" name="name"
                                                    id="name" value="{{ old('name', $product->name) }}" />
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="number"
                                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                                    value="{{ old('price', $product->price) }}" />
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="slug">Slug</label>
                                                <input type="text"
                                                    class="form-control @error('slug') is-invalid
                                                @enderror"
                                                    name="slug" id="slug" placeholder="Slug..." readonly required
                                                    value="{{ old('slug', $product->slug) }}">
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Kategori Produk</label>
                                                <select name="categories_id" id="categories_id"
                                                    class="form-control @error('categories_id')
                                                    is-invalid
                                                @enderror">
                                                    @foreach ($categories as $category)
                                                        @if ($category->id == $product->categories_id)
                                                            <option value="{{ $category->id }}" selected>
                                                                {{ $category->name }}</option>
                                                        @else
                                                            <option value="{{ $category->id }}">
                                                                {{ $category->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($product->galleries as $gallery)
                                        <div class="col-md-4">
                                            <div class="gallery-container">
                                                <img src="{{ Storage::url($gallery->photos ?? '') }}" alt=""
                                                    class="w-100" />
                                                <a href="{{ route('dashboard-product-gallery-delete', $gallery->id) }}"
                                                    class="delete-gallery">
                                                    <img src="/images/icon-delete.svg" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-12">
                                        <form action="{{ route('dashboard-product-gallery-upload') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="products_id" value="{{ $product->id }}">
                                            <input type="file" id="file" name="photos" style="display: none"
                                                onchange="form.submit()" />
                                            <button type="button" class="btn btn-secondary btn-block mt-3"
                                                onclick="thisFileUpload()">
                                                Add Photo
                                            </button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        function thisFileUpload() {
            document.getElementById("file").click();
        }
    </script>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor");
    </script>
    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        console.log(name.value);
        name.addEventListener('change', function() {
            fetch('/dashboard/product/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });
    </script>
@endpush
