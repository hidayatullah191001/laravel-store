@extends('layouts.dashboard')

@section('title')
    Store Dashboard Settings
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Store Settings</h2>
                <p class="dashboard-subtitle">Make store that profitable</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('dashboard-settings-redirect', 'dashboard-settings-store') }}"
                            method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Toko</label>
                                                <input type="text" name="store_name" id="store_name"
                                                    class="form-control @error('store_name')is-invalid @enderror"
                                                    value="{{ $user->store_name }}" />
                                                @error('store_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="categories_id" id="kategori" class="form-control">
                                                    @foreach ($categories as $category)
                                                        @if ($category->id == $user->categories_id)
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Store <Status></Status></label>
                                                <p class="text-muted">
                                                    Apakah saat ini toko Anda buka?
                                                </p>
                                                <div class="custom-control custom-radio custon-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreTrue" value="1"
                                                        {{ $user->store_status == 1 ? 'checked' : '' }} />
                                                    <label for="openStoreTrue" class="custom-control-label">Buka</label>
                                                </div>
                                                <div class="custom-control custom-radio custon-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreFalse" value="2"
                                                        {{ $user->store_status == 0 || $user->store_status == null ? 'checked' : '' }} />

                                                    <label for="openStoreFalse" class="custom-control-label">Sementara
                                                        Tutup</label>
                                                </div>
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
            </div>
        </div>
    </div>
@endsection
