@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cylinder Categories</h4>
                    <h6>Manage Cylinder Categories</h6>
                </div>
                <div class="page-btn">
                    <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addCylinderCategory">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Cylinder
                        Category
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
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

                                    <th>Cylinder Category Name</th>

                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cylinderCategories as $cylinderCategory)
                                    <tr>

                                        <td>{{ $cylinderCategory->name }}</td>

                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="user{{ $cylinderCategory->id }}"
                                                    class="check cylinder-status" data-id="{{ $cylinderCategory->id }}"
                                                    {{ $cylinderCategory->status === 1 ? 'checked' : '' }}>
                                                <label for="user{{ $cylinderCategory->id }}"
                                                    class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $cylinderCategory->creator->getRoleNames()->first() ?? 'No Role')) }}
                                        </td>


                                        <td class="text-end">
                                            <a class="btn btn-sm btn-primary editBtn" href="javascript:void(0);"
                                                data-id="{{ $cylinderCategory->id }}"
                                                data-name="{{ $cylinderCategory->name }}" data-bs-toggle="modal"
                                                data-bs-target="#editCylinderCategory">
                                                Edit
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                       <div class="pagination-wrapper">
                        {{ $cylinderCategories->links() }}
                     </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    <div class="modal fade" id="addCylinderCategory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Cylinder Category </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cylinder-category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Name<span class="manitory">*</span></label>
                                    <input type="text" name="name" class="form-control">
                                    @error('name')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Confirm</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCylinderCategory" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cylinder Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Cylinder Category Name<span class="manitory">*</span></label>
                                    <input type="text" name="name" id="editName" class="form-control" required>
                                     @error('record')
                                        <div class="text-danger">
                                            {{$message}}
                                        </div>
                                     @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Update</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@section('script')
    <script>
        document.querySelectorAll('.editBtn').forEach(button => {

            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let name = this.getAttribute('data-name');

                document.getElementById('editName').value = name;
                document.getElementById('editForm').action = '/cylinder-category/update/' + id;
            });
        });
    </script>
    <script>
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('cylinder-status')) {

                let checkbox = e.target;
                let userId = checkbox.dataset.id;
                let status = checkbox.checked ? 1 : 0;

                fetch("{{ route('cylinder-category.status.update') }}", {
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
                            Swal.fire('Success', 'Cylinder Category status updated successfully', 'success');
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
