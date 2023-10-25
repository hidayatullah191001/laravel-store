@extends('layouts.admin')

@section('title')
    User
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">User</h2>
                <p class="dashboard-subtitle">Edit User</p>
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
                                <form action="/admin/user/{{ $user->email }}" method="POST" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Nama User</label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control @error('name') is-invalid
                                                    @enderror"
                                                    required value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Email User</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control @error('email') is-invalid
                                                    @enderror"
                                                    required value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Password User</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid
                                                    @enderror">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small>Kosongkan jika password tidak ingin diubah</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Role User</label>
                                                <select name="role" id="role"
                                                    class="form-control @error('role')
                                                    is-invalid
                                                @enderror">
                                                    @php
                                                        $selected = false;
                                                        if ($user->roles == 'ADMIN') {
                                                            $selected = true;
                                                        } else {
                                                            $selected = false;
                                                        }
                                                    @endphp
                                                    <option value="ADMIN" selected = "{{ $selected }}">ADMIN</option>
                                                    <option value="USER" selected={{ $selected }}>USER</option>
                                                </select>
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
