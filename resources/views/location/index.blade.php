@extends('layouts.master')
@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h6>Location List</h6>
                </div>

                <div class="page-btn">
                    <a href="{{ route('location.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-2">
                        Add Location
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <!-- Filter Form -->


                    <form method="GET" action="{{ route('location.list') }}">
                        <div class="row">

                            <!-- Product Name -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="name" value="{{ request('name') }}"
                                        placeholder="Search by Location Name" class="form-control">
                                </div>
                            </div>



                            <!-- Buttons -->
                            <div class="col-lg-3 col-sm-6 col-12 ms-auto">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Search
                                    </button>

                                    <a href="{{ route('location.list') }}" class="btn btn-secondary px-4">
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
                                    <th>Location Name</th>
                                    <th>Cylinder Categories & Price</th>
                                    <th>Update Date</th>
                                    <th>Last Updated By</th>
                                    @role('super_admin')
                                    <th>Action</th>
                                    @endrole
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($locations as $location)
                                    <tr>
                                        <td>{{ $location->location_name }}</td>


                                        <td>
                                            @foreach ($location->locationCylinderCategories as $category)
                                                <div>
                                                    <strong>{{ $category->category->name }}</strong>
                                                    - ₹{{ number_format($category->price, 2) }}
                                                </div>
                                            @endforeach
                                        </td>


                                        <td>

                                            {{ $location->created_at->format('d/m/Y') }}
                                        </td>
                                        {{-- <td>{{$location->created_by}}</td> --}}
                                        <td>{{$location->creator->name}} ({{ ucfirst(str_replace('_', ' ', $location->creator->getRoleNames()->first() ?? 'No Role')) }})
                                        </td>


                                        @can('edit_location')
                                            <td>
                                                <a href="{{ route('location.edit', $location->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>
                                            </td>
                                        @endcan

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No locations found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <div class="pagination-wrapper">
                        {{ $locations->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
