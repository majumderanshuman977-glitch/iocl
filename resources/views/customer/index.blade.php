@extends('layouts.master')
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>New Customer</h4>
                    <h6>Manage Customer</h6>
                </div>
                <div class="page-btn">
                    <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addCustomer">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Customer

                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">


                    <form method="GET" action="{{ route('customers.index') }}">
                        <div class="row">
                            <div class="col-lg-5 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ request('name') }}"
                                        placeholder="Enter Customer Name/Mobile Number/Address" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="0"
                                            {{ request('status') !== null && request('status') == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-6 col-12 ms-auto">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-filters px-5 py-3">
                                        <img src="{{ asset('assets/img/icons/search-whites.svg') }}" class="me-2">
                                        Search
                                    </button>

                                    <a href="{{ route('customers.index') }}" class="btn btn-filters px-5 py-3">
                                        <img src="{{ asset('assets/img/icons/closes.svg') }}" class="me-2">
                                        Reset
                                    </a>


                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th>Customer Name</th>
                                    <th>Mobile Number</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>

                                        <td>{{ $customer->customer_name }}</td>
                                        <td>{{ $customer->mobile_number }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="customer{{ $customer->id }}"
                                                    class="check customer-status" data-id="{{ $customer->id }}"
                                                    {{ $customer->status === 1 ? 'checked' : '' }}>
                                                <label for="customer{{ $customer->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $customer->creator->getRoleNames()->first() ?? 'No Role')) }}
                                        </td>


                                        <td>
                                            <a class="btn btn-sm btn-primary editCustomerBtn" href="javascript:void(0);"
                                                data-id="{{ $customer->id }}" data-bs-toggle="modal"
                                                data-bs-target="#editCustomer">
                                                Edit
                                            </a>


                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ADD customer modal  --}}
    <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Customer </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">

                            <!-- Customer Name -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                    class="form-control @error('customer_name') is-invalid @enderror">

                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" name="mobile_number" value="{{ old('mobile_number') }}"
                                    class="form-control @error('mobile_number') is-invalid @enderror" required>

                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ID Number -->
                            <div class="col-12 mb-3">
                                <label class="form-label">ID Number</label>
                                <input type="text" name="id_number" value="{{ old('id_number') }}"
                                    class="form-control @error('id_number') is-invalid @enderror">

                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ID Proof File -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Upload ID Proof</label>
                                <div class="mb-2" id="addIdPreviewContainer" style="display:none;"
                                    onclick="window.open(this.src, '_blank')">
                                    <img id="addIdPreview" src="" alt="ID Proof Preview"
                                        style="max-width:150px; max-height:120px; border:1px solid #ddd; padding:5px; border-radius:5px; object-fit:cover;">
                                </div>
                                <input type="file" name="id_file" id="addIdFile"
                                    class="form-control @error('id_file') is-invalid @enderror">

                                @error('id_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save Customer
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- EDit customer modal  --}}
    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="modal-body">
                        <div class="row">

                            <!-- Customer Name -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_name" id="editCustomerName" class="form-control"
                                    required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="mobile_number" id="editPhone" class="form-control" required>
                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-12 mb-3">
                                <label class="form-label">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <textarea name="address" id="editAddress" class="form-control" rows="3" required></textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-12 mb-3">
                                <label class="form-label">ID Number</label>
                                <input type="text" name="id_number" id="editIdNumber" class="form-control">
                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-12 mb-3">
                                <label class="form-label">Upload New ID Proof</label>

                                <!-- Old Image Preview -->
                                <div class="mb-2" id="oldIdPreviewContainer" style="display:none;">
                                    <img id="oldIdPreview" src="" alt="ID Proof"
                                        onclick="window.open(this.src, '_blank')"
                                        style="max-width:150px; max-height:120px; border:1px solid #ddd; padding:5px; border-radius:5px;">
                                </div>

                                <input type="file" name="id_file" id="editIdFile" class="form-control">

                                @error('id_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Update Customer
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@section('script')
    <script>
        document.getElementById('addIdFile').addEventListener('change', function() {
            const file = this.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('addIdPreview').src = e.target.result;
                    document.getElementById('addIdPreviewContainer').style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                document.getElementById('addIdPreview').src = '';
                document.getElementById('addIdPreviewContainer').style.display = 'none';
            }
        });

        document.querySelectorAll('.editCustomerBtn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let name = this.getAttribute('data-name');




                document.getElementById('editForm').action = '/new-connection/customers/' + id;


                fetch('/new-connection/customers/' + id + '/edit')
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('editCustomerName').value = data.customer_name;
                        document.getElementById('editPhone').value = data.mobile_number ?? '';
                        document.getElementById('editAddress').value = data.address ?? '';
                        document.getElementById('editIdNumber').value = data.id_proof_number ?? '';


                        if (data.id_proof) {
                            document.getElementById('oldIdPreview').src = '/storage/' + data.id_proof;
                            document.getElementById('oldIdPreviewContainer').style.display = 'block';
                        } else {
                            document.getElementById('oldIdPreviewContainer').style.display = 'none';
                        }
                    })
                    .catch(() => Swal.fire('Error', 'Failed to load customer data', 'error'));
            });
        });


        document.getElementById('editIdFile').addEventListener('change', function() {
            const file = this.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('oldIdPreview').src = e.target.result;
                    document.getElementById('oldIdPreviewContainer').style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {

                document.getElementById('oldIdPreview').src = '';
                document.getElementById('oldIdPreviewContainer').style.display = 'none';
            }
        });
    </script>

    <script>
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('customer-status')) {

                let checkbox = e.target;
                let userId = checkbox.dataset.id;
                let status = checkbox.checked ? 1 : 0;

                fetch("{{ route('customer.status.update') }}", {
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
                            Swal.fire('Success', 'Customer status updated successfully', 'success');
                        }
                    })
                    .catch(() => {
                        checkbox.checked = !checkbox.checked;
                        Swal.fire('Error', 'Something went wrong', 'error');
                    });
            }

        });
    </script>
@endsection
@endsection
