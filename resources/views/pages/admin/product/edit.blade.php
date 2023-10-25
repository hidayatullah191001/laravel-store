@extends('layouts.admin')

@section('title')
    Produk
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Produk</h2>
                <p class="dashboard-subtitle">Edit Produk</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="/admin/product/{{ $product->slug }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Nama Produk</label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control @error('name') is-invalid
                                                    @enderror"
                                                    required value="{{ old('name', $product->name) }}">
                                                @error('name')
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
                                                <label for="">Pemilik Produk</label>
                                                <select name="users_id" id="users_id"
                                                    class="form-control @error('users_id')
                                                    is-invalid
                                                @enderror">
                                                    @foreach ($users as $user)
                                                        @if ($user->id == $product->users_id)
                                                            <option value="{{ $user->id }}" selected>
                                                                {{ $user->name }}</option>
                                                        @else
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
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
                                                <label for="">Harga Produk</label>
                                                <input type="number" name="price" id="price"
                                                    class="form-control @error('price') is-invalid
                                                    @enderror"
                                                    required value="{{ old('price', $product->price) }}">
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Deskripsi Produk</label>
                                                <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button class="btn btn-success px-5" type="submit">Save Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor");
    </script>
    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        console.log(name.value);
        name.addEventListener('change', function() {
            fetch('/admin/products/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });
    </script>
@endpush
