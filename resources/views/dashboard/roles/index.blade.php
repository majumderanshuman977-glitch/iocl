@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Roles</h4>
                    <h6>Manage Roles Settings</h6>
                </div>
                <div class="page-btn">
                    <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addRole">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Role
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
                        {{-- <div class="wordset"> --}}
                            {{-- <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                                        <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                        <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="img">
                                    </a>
                                </li>
                            </ul> --}}
                        {{-- </div> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                            <span class="badge bg-primary">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>

                                    <td class="text-end">
                                        <a class="me-3 editBtn" href="javascript:void(0);" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-permissions="{{ implode(',', $role->permissions->pluck('id')->toArray()) }}"
                                            data-bs-toggle="modal" data-bs-target="#editRole">
                                            <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                        </a>
                                        {{-- <a class="me-3 confirm-text" href="javascript:void(0);">
                                            <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                        </a> --}}
                                         <a class="me-3 deleteBtn" href="javascript:void(0);"
                                                data-id="{{ $role->id }}">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
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
    <!-- End Page-content -->
    <div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Roles </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Role Name<span class="manitory">*</span></label>
                                <input type="text" class="form-control" name="role_name" required>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Permissions <span class="manitory">*</span></label>
                                <select class="select" name="permissions[]" multiple required>
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
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

   <div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('POST')

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Role Name<span class="manitory">*</span></label>
                                <input type="text" name="role_name" id="editName" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Permissions</label>
                                <select class="select" name="permissions[]" id="editPermissions" multiple>
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
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
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function () {

            let id = this.getAttribute('data-id');
            let name = this.getAttribute('data-name');
            let permissions = this.getAttribute('data-permissions');

            permissions = permissions ? permissions.split(',') : [];


            document.getElementById('editName').value = name;


            document.getElementById('editForm').action = '/role/update/' + id;


            let select = document.getElementById('editPermissions');


            Array.from(select.options).forEach(option => {
                option.selected = false;
            });


            permissions.forEach(id => {
                let option = select.querySelector('option[value="' + id + '"]');
                if (option) option.selected = true;
            });


            if ($(select).hasClass('select2-hidden-accessible')) {
                $(select).trigger('change');
            }

        });
    });

});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function () {

            let id = this.getAttribute('data-id');
            let row = this.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This permission will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch(`/role/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            row.remove();

                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    });
                }
            });
        });
    });

});
</script>

@endsection
@endsection
