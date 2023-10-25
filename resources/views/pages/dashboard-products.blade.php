@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">Manage it well and get money</p>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href={{ route('dashboard-products-create') }} class="btn btn-success">Add New Products</a>
                    </div>
                </div>
                <div class="row mt-4">

                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href={{ route('dashboard-products-details', $product->slug) }}
                                class="card card-dashboard-product d-block">
                                <div class="card-body">
                                    <img src="{{ Storage::url($product->galleries->first()->photos ?? '') }}"
                                        class="w-100 mb-2" alt="" />
                                    <div class="product-title">{{ $product->name }}</div>
                                    <div class="product-category">{{ $product->category->name }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
