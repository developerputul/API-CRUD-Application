
@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">All Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Product <span class="badge rounded-pill bg-danger">{{ count($tests) }}</span></li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="#" class="btn btn-primary">Add Product</a>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <select id="search-bar">
                    <option value="" disable selected>Select a filter</option>
                    @foreach ($tests as $key => $item)
                        <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                    @endforeach
                </select>
                <select id="filter-date">
                    <option value="asc">Accending</option>
                    <option value="desc" selected>Decending</option>
                </select>
                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Selling Price</th>
                            <th>Discount Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-tbody">
                        @foreach ($tests as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{ asset($item->product_thambnail) }}" style="width:70px; height:40px;"></td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->selling_price }}</td>
                            <td>
                                @if ($item->discount_price == null)
                                <span class="badge rounded-pill bg-info">No Discount</span>
                                @else
                                @php
                                $amount = $item->selling_price - $item->discount_price;
                                $discount = ($amount / $item->selling_price) * 100;
                                @endphp
                                <span class="badge rounded-pill bg-danger">{{ round($discount) }}%</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('edit.product', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('delete.product', $item->id) }}" class="btn btn-danger" title="Delete Data" id="delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // CSRF token setup for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function fetchProducts() {
            let searchQuery = $('#search-bar').val();
            let sortOrder = $('#filter-date').val();

            // AJAX call to fetch data
            $.ajax({
                url: "{{ route('putulee.route') }}", // Your API route
                type: "GET",
                data: { search: searchQuery, sort: sortOrder },
                success: function (response) {
                    // Clear the current table body
                    $('#product-tbody').empty();

                    // Populate the table body with new data
                    response.forEach(function (product, index) {
                        let discountBadge = product.discount_price
                            ? `<span class="badge rounded-pill bg-danger">${Math.round(((product.selling_price - product.discount_price) / product.selling_price) * 100)}%</span>`
                            : `<span class="badge rounded-pill bg-info">No Discount</span>`;

                        let row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td><img src="/${product.product_thambnail}" style="width:70px; height:40px;"></td>
                                <td>${product.product_name}</td>
                                <td>${product.selling_price}</td>
                                <td>${discountBadge}</td>
                                <td>
                                    <a href="/edit-product/${product.id}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                    <a href="/delete-product/${product.id}" class="btn btn-danger" title="Delete Data"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        `;
                        $('#product-tbody').append(row); // Append the new row
                    });
                },
                error: function (xhr) {
                    console.error('Error fetching data:', xhr);
                }
            });
        }

        // Trigger fetchProducts when either dropdown changes
        $('#search-bar, #filter-date').on('change', fetchProducts);
    });
</script>
