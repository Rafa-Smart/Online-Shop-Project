@extends('SellerDashboard.layouts.app')

@section('title', 'Stock Management')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">
        📦 Stock Management
    </h3>

    {{-- FILTER STOK --}}
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="number" name="stock_filter" class="form-control"
                    value="{{ $filterStock }}" min="0">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    {{-- LIST PRODUK --}}
    <div class="card shadow-sm p-3">
        <h5>Produk Dengan Stok Rendah (≤ {{ $filterStock }})</h5>

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-light">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Update Stok</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                <tr>
                    <td width="80">
                        <img src="{{ asset($product->img) }}" class="img-fluid rounded">
                    </td>

                    <td>{{ $product->product_name }}</td>

                    <td>
                        <span class="badge 
                            @if($product->stock <= $defaultThreshold) bg-danger 
                            @else bg-secondary 
                            @endif">
                            {{ $product->stock }}
                        </span>
                    </td>

                    <td>
                        <form action="{{ route('seller.stock.update', $product->id) }}" method="POST" class="d-flex">
                            @csrf
                            <input type="number" name="stock" class="form-control me-2"
                                value="{{ $product->stock }}" min="0" style="width: 90px;">
                            <button class="btn btn-success btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-muted">
                            Tidak ada produk dengan stok rendah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
