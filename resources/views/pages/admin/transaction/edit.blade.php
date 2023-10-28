@extends('layouts.admin')

@section('title')
    Transaction
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaction</h2>
                <p class="dashboard-subtitle">Edit Transaction</p>
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
                                <form action="/admin/transaction/{{ $transaction->id }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Transaction Status</label>
                                                <select name="transaction_status" id="transaction_status"
                                                    class="form-control">
                                                    <option value="{{ $transaction->transaction_status }}" selected>
                                                        {{ $transaction->transaction_status }}</option>
                                                    <option value="" disabled>-------------------</option>
                                                    <option value="PENDING">PENDING</option>
                                                    <option value="SHIPPING">SHIPPING</option>
                                                    <option value="SUCCESS">SUCCESS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Total Price</label>
                                                <input type="number" name="total_price" id="total_price"
                                                    class="form-control @error('total_price') is-invalid
                                                    @enderror"
                                                    required value="{{ old('total_price', $transaction->total_price) }}">
                                                @error('total_price')
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
