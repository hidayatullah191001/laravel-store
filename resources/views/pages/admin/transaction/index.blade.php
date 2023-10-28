@extends('layouts.admin')

@section('title')
    Transaction
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">List of transaction</p>
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

                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Total Price</th>
                                                <th>Transaction Status</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaction->user->name }}</td>
                                                    <td>{{ $transaction->total_price }}</td>
                                                    <td>{{ $transaction->transaction_status }}</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                                                    type="button" data-toggle="dropdown"> Aksi</button>
                                                                <div class="dropdown-menu">
                                                                    <a href={{ route('transaction.edit', $transaction->id) }}
                                                                        class="dropdown-item">Sunting</a>
                                                                    <form
                                                                        action={{ route('transaction.destroy', $transaction->id) }}
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
