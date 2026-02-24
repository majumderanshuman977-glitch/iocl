@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sub Admin List</h4>
                    <h6>Manage your Sub Admin</h6>
                </div>


                <div class="page-btn">
                    <a href="{{ route('user.subadmin.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-2">Add Sub Admin
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('user.subadmin') }}">
                        <div class="row">
                            <div class="col-lg-5 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ request('name') }}"
                                        placeholder="Search by User Name/Mobile Number" class="form-control">
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


                            <div class="col-lg-3 col-sm-6 col-12 ms-auto">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Search
                                    </button>

                                    <a href="{{ route('user.subadmin') }}" class="btn btn-secondary px-4">
                                        Reset
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>

                                    <th>Profile</th>
                                    <th>User name </th>
                                    <th>Phone</th>
                                    <th>email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $u)
                                    <tr id="user-row-{{ $u->id }}">

                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ isset($u->avatar) ? asset('storage/' . $u->avatar) : asset('assets/img/profiles/avatar-02.jpg') }}"
                                                    alt="product">
                                            </a>
                                        </td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->mobile }}</td>
                                        <td>{{ $u->email }}</td>

                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="user{{ $u->id }}"
                                                    class="check user-status" data-id="{{ $u->id }}"
                                                    {{ $u->status === 'active' ? 'checked' : '' }}>
                                                <label for="user{{ $u->id }}" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>


                                        <td>


                                            <a href="{{ route('user.permissions.subadmin', $u->id) }}"
                                                class="btn btn-sm btn-success">
                                                Permissions
                                            </a>

                                            <a href="{{ route('user.subadmin.edit', $u->id) }}"
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
                        {{ $user->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- End Page-content -->





@section('script')
    <script>
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('user-status')) {

                let checkbox = e.target;
                let userId = checkbox.dataset.id;
                let status = checkbox.checked ? 'active' : 'inactive';

                fetch("{{ route('user.status.update') }}", {
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
                            Swal.fire('Success', 'User status updated successfully', 'success');

                        }
                    })
                    .catch(() => {
                        checkbox.checked = !checkbox.checked;
                        Swal.fire('Error', 'Something went wrong', 'error');
                    })

            }
        });
        // document.querySelectorAll('.user-status').forEach(function(toggle) {
        //     toggle.addEventListener('change', function() {

        //         let userId = this.dataset.id;
        //         let status = this.checked ? 'active' : 'inactive';
        //         let checkbox = this;

        //         fetch("{{ route('user.status.update') }}", {
        //                 method: "POST",
        //                 headers: {
        //                     "Content-Type": "application/json",
        //                     "X-CSRF-TOKEN": "{{ csrf_token() }}"
        //                 },
        //                 body: JSON.stringify({
        //                     id: userId,
        //                     status: status
        //                 })
        //             })
        //             .then(res => res.json())
        //             .then(data => {
        //                 if (data.success) {
        //                     Swal.fire('Success', 'User status updated successfully', 'success');

        //                 }
        //             })
        //             .catch(() => {
        //                 checkbox.checked = !checkbox.checked;
        //                 Swal.fire('Error', 'Something went wrong', 'error');

        //             });

        //     });
        // });
    </script>
@endsection
@endsection
