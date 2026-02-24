@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Products List</h4>
                    <h6>Manage your Products</h6>
                </div>

                <div class="page-btn">
                    <a href="{{ route('products.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-2">Add Product
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <!-- Filter Form -->


                    <form method="GET" action="{{ route('products.list') }}">
                        <div class="row">

                            <!-- Product Name -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ request('name') }}"
                                        placeholder="Search by Product Name" class="form-control">
                                </div>
                            </div>

                            <!-- Date Range -->
                            {{-- <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="date_range" id="date_range"
                                        value="{{ request('date_range') }}" placeholder="Select Date Range"
                                        class="form-control">
                                </div>
                            </div> --}}

                            <!-- Buttons -->
                            <div class="col-lg-3 col-sm-6 col-12 ms-auto">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Search
                                    </button>

                                    <a href="{{ route('products.list') }}" class="btn btn-secondary px-4">
                                        Reset
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>


                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock Qty</th>
                                    <th>Status</th>
                                    <th>Update Date</th>
                                    <th>Last Updated By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr id="product-row-{{ $product->id }}">
                                        <td>{{ $product->product_name }}</td>
                                        <td>₹{{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning open-stock-modal"
                                                data-id="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                                data-stock="{{ $product->quantity }}" data-bs-toggle="modal"
                                                data-bs-target="#stockModal">
                                                {{ $product->quantity }}
                                            </button>

                                        </td>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="product{{ $product->id }}"
                                                    class="check product-status" data-id="{{ $product->id }}"
                                                    {{ $product->status === 1 ? 'checked' : '' }}>
                                                <label for="product{{ $product->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                        <td>{{ $product->created_at->format('d-m-Y') }}</td>

                                        {{-- <td> {{ $product->creator->getRoleNames()->first() ?? 'No Role' }}</td> --}}
                                        <td>
                                           {{$product->creator->name}} ({{ ucfirst(str_replace('_', ' ', $product->creator->getRoleNames()->first() ?? 'No Role')) }})
                                        </td>

                                        <td>


                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>



                </div>
            </div>

        </div>
    </div>

    <!-- Stock Update Modal -->
    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Stock - <span id="stockProductName"></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="stockForm" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" id="stockProductId">

                    <div class="modal-body">
                        <div class="row">

                            <!-- Current Stock Display -->

                            <input type="hidden" id="currentStock" value="{{ $product->quantity }}">

                            <!-- Type -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Type<span class="manitory">*</span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        <option value="add">Add Stock</option>
                                        <option value="remove">Remove Stock</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Quantity<span class="manitory">*</span></label>
                                    <input type="number" name="quantity" class="form-control" min="1" required>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Date<span class="manitory">*</span></label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <!-- Remark -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea name="remark" class="form-control" rows="3" placeholder="Enter remark (optional)"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Update Stock</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $(function() {

            document.querySelectorAll('.open-stock-modal').forEach(button => {
                button.addEventListener('click', function() {

                    let id = this.dataset.id;
                    let name = this.dataset.name;


                    document.getElementById('stockProductId').value = id;


                    document.getElementById('stockProductName').textContent = name;

                    let url = "{{ route('products.stock.update', ':id') }}";
                    url = url.replace(':id', id);
                    document.getElementById('stockForm').action = url;



                    document.getElementById('stockForm').reset();

                    document.querySelector('#stockForm input[name="date"]').value =
                        "{{ date('Y-m-d') }}";
                });
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('product-status')) {

                    let checkbox = e.target;
                    let userId = checkbox.dataset.id;
                    let status = checkbox.checked ? 1 : 0;

                    fetch("{{ route('products.status.update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: userId,
                                status: status
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success', 'Product status updated successfully',
                                    'success');
                            }
                        })
                        .catch(() => {
                            checkbox.checked = !checkbox.checked;
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });
                }
            });

        });
    </script>
@endsection
@endsection
