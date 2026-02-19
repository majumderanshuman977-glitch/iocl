@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Delivery Boy List</h4>
                    <h6>Manage your Delivery Boys</h6>
                </div>


                <div class="page-btn">
                    <a href="{{ route('delivery-boy.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-2">Add Delivery Boy
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">


                    <form method="GET" action="{{ route('delivery-boy.list') }}">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ request('name') }}"
                                        placeholder="Enter Vehicle Name/Phone Number" class="form-control">
                                </div>
                            </div>


                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select name="van_type" class="form-control">
                                        <option value="">Select Vehicle Type</option>
                                        <option value="small_van"
                                            {{ request('van_type') == 'small_van' ? 'selected' : '' }}>
                                            Small Van
                                        </option>
                                        <option value="large_van"
                                            {{ request('van_type') == 'large_van' ? 'selected' : '' }}>
                                            Large Van
                                        </option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                            Incative
                                        </option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
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

                                    <a href="{{ route('delivery-boy.list') }}" class="btn btn-filters px-5 py-3">
                                        <img src="{{ asset('assets/img/icons/closes.svg') }}" class="me-2">
                                        Reset
                                    </a>


                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="table-responsive">
                        <table class="table">

                            <thead>


                                <th>Name/Vehicle</th>
                                <th>Vehicle Type </th>
                                <th>Phone</th>
                                <th>Capacity</th>
                                <th>PF/ESI Status</th>
                                <th>Status</th>
                                <th>Created By</th>
                                @can('edit_delivery_boys')
                                    <th>Action</th>
                                @endcan

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveryBoy as $db)
                                    <tr id="user-row-{{ $db->id }}">

                                        <td>
                                            @if ($db->van_type === 'large_van')
                                                {{ $db->vehicle_name }}
                                            @else
                                                {{ $db->driver_name }}
                                            @endif
                                        </td>
                                        <td>{{ str_replace('_', ' ', $db->van_type) }}</td>
                                        <td>{{ $db->mobile_number }}</td>
                                        <td>{{ $db->max_cylinder_capacity }}</td>
                                        <td>{{ $db->is_pf_esi ? 'Yes' : 'No' }}</td>

                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="user{{ $db->id }}" class="check db-status"
                                                    data-id="{{ $db->id }}"
                                                    {{ $db->status === 1 ? 'checked' : '' }}>
                                                <label for="user{{ $db->id }}" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>

                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $db->creator->getRoleNames()->first() ?? 'No Role')) }}
                                        </td>
                                        @can('edit_delivery_boys')
                                            <td>
                                                <a href="{{ route('delivery-boy.edit', $db->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>

                                            </td>
                                        @endcan

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="pagination-wrapper">
                        {{ $deliveryBoy->links() }}
                    </div>


                </div>
            </div>

        </div>
    </div>



@section('script')
    <script>
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('db-status')) {

                let checkbox = e.target;
                let userId = checkbox.dataset.id;
                let status = checkbox.checked ? 1 : 0;

                fetch("{{ route('delivery-boy.status.update') }}", {
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
                            Swal.fire('Success', 'Delivery Boy status updated successfully', 'success');
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
