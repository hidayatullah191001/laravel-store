@extends('layouts.admin')

@section('title')
    Products
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Products</h2>
                <p class="dashboard-subtitle">List of products</p>
            </div>
            <div class="dashboard-content">

                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product.create') }}" class="btn btn-primary mb-3"> + Tambah Product</a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Pemilik</th>
                                                <th>Kategori</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->user->name }}</td>
                                                    <td>{{ $product->category->name }}</td>
                                                    <td>{{ $product->price }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                                                    type="button" data-toggle="dropdown"> Aksi</button>
                                                                <div class="dropdown-menu">
                                                                    <a href={{ route('product.edit', $product->slug) }}
                                                                        class="dropdown-item">Sunting</a>
                                                                    <form
                                                                        action={{ route('product.destroy', $product->slug) }}
                                                                        method="POST">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger"
                                                                            onclick="return confirm('Are you sure?')">Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
        $(document).ready(function() {
            $('#crudTable').DataTable();
        });
        // var datatable = $('#crudTable').DataTable({
    </script>
@endpush
