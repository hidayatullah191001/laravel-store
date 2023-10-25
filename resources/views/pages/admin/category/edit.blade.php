@extends('layouts.admin')

@section('title')
    Category
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Category</h2>
                <p class="dashboard-subtitle">Edit Category</p>
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
                                <form action="/admin/category/{{ $category->slug }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nama Kategori</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control @error('name') is-invalid
                                                            @enderror"
                                                            required value="{{ old('name', $category->name) }}">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="slug">Slug</label>
                                                        <input type="text"
                                                            class="form-control @error('slug') is-invalid
                                                        @enderror"
                                                            name="slug" id="slug" placeholder="Slug..." readonly
                                                            required value="{{ old('slug', $category->slug) }}">
                                                        @error('slug')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Photo</label>
                                                <input type="hidden" name="oldPhoto" value="{{ $category->photo }}">
                                                @if ($category->photo)
                                                    <img style="width: 100px"
                                                        class="photo-preview img-fluid mb-3 col-sm-3 d-block" alt=""
                                                        src="{{ asset('storage/' . $category->photo) }}">
                                                @else
                                                    <img style="width:100px" class="photo-preview img-fluid mb-3 col-sm-3"
                                                        alt="">
                                                @endif

                                                <input
                                                    class="form-control @error('photo') is-invalid
                                                @enderror"
                                                    type="file" id="photo" name="photo" onchange="previewImage()">
                                                @error('photo')
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
    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        console.log(name.value);
        name.addEventListener('change', function() {
            fetch('/admin/categories/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });

        function previewImage() {
            const photo = document.querySelector('#photo');
            const imgPreview = document.querySelector('.photo-preview');

            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(photo.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
