@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Permission Management</h4>
                    <h6>Assign Permissions</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('user.permission.assign') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Select Permissions</label>
                                           <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-lg-3 col-sm-6 col-12 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" id="perm{{ $permission->id }}"
                                                        {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="perm{{ $permission->id }}">
                                                        {{ Str::title(str_replace('_', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Save Permissions
                                </button>


                                    @if ($user->hasRole('super_admin'))
                                 <a href="{{ route('user.superadmin') }}" class="btn btn-cancel">
                                    Cancel
                                </a>

                                @else
                                <a href="{{ route('user.subadmin') }}" class="btn btn-cancel">
                                    Cancel
                                </a>
                                    @endif

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
