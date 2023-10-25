@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transactions
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12 mt-2">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">Sell Product</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Buy Product</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">

                                @foreach ($sell_transactions as $sell)
                                    <a href={{ route('dashboard-transactions-details', $sell->id) }}
                                        class="card card-list d-block">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img style="width: 44px"
                                                        src="{{ Storage::url($sell->product->galleries->first()->photos ?? '') }}"
                                                        class="w-50" />
                                                </div>
                                                <div class="col-md-4">{{ $sell->product->name }}</div>
                                                <div class="col-md-3">{{ $sell->product->user->store_name }}</div>
                                                <div class="col-md-3">{{ $sell->created_at }}</div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/icon-arrow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>


                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                @foreach ($buy_transactions as $buy)
                                    <a href={{ route('dashboard-transactions-details', $buy->id) }}
                                        class="card card-list d-block">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img style="width: 44px"
                                                        src="{{ Storage::url($buy->product->galleries->first()->photos ?? '') }}"
                                                        class="w-50" />
                                                </div>
                                                <div class="col-md-4">{{ $buy->product->name }}</div>
                                                <div class="col-md-3">{{ $buy->product->user->store_name }}</div>
                                                <div class="col-md-3">{{ $buy->created_at }}</div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/icon-arrow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
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
@endpush
