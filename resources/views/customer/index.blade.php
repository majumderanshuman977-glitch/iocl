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
                                        placeholder="Search by Customer Name/Mobile Number" class="form-control">
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

                            <div class="col-lg-3 col-sm-6 col-12 ms-auto">
                                <div class="form-group d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Search
                                    </button>

                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary px-4">
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
                                    <th>Status</th>
                                    <th>Last Updated By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>

                                        <td>{{ $customer->first_name }} {{ $customer->middle_name }}
                                            {{ $customer->last_name }} </td>
                                        <td>{{ $customer->mobile_number }}</td>

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
                                            {{ $customer->creator->name }}
                                        </td>


                                        <td>
                                            <a class="btn btn-sm btn-primary editCustomerBtn" href="javascript:void(0);"
                                                data-id="{{ $customer->id }}" data-title="{{ $customer->title }}"
                                                data-first_name="{{ $customer->first_name }}"
                                                data-middle_name="{{ $customer->middle_name }}"
                                                data-last_name="{{ $customer->last_name }}"
                                                data-dob="{{ $customer->dob }}"
                                                data-gas_consumer_number="{{ $customer->gas_consumer_number }}"
                                                data-guardian_name="{{ $customer->father_spouse_name }}"
                                                data-mother_name="{{ $customer->mother_name }}"
                                                data-house_flat_no="{{ $customer->house_flat_no }}"
                                                data-street="{{ $customer->street }}"
                                                data-landmark="{{ $customer->landmark }}"
                                                data-city="{{ $customer->city }}"
                                                data-district="{{ $customer->district }}"
                                                data-state="{{ $customer->state }}"
                                                data-pin_code="{{ $customer->pin_code }}"
                                                data-mobile_number="{{ $customer->mobile_number }}"
                                                data-email="{{$customer->email}}"
                                                data-landline="{{ $customer->landline }}"
                                                data-id_number="{{ $customer->id_number }}"
                                                data-ration_card_number="{{ $customer->ration_card_number }}"
                                                data-profile_image="{{ $customer->profile_image }}" data-id_front_image="{{ $customer->id_front_image }}"
                                                data-id_back_image="{{ $customer->id_back_image }}" data-bs-toggle="modal" data-bs-target="#editCustomer">
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

                            <div class="col-12 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">1. Personal Details</h6>
                            </div>


                            <div class="col-md-3 mb-2"> <label class="form-label small">Title <span
                                        class="text-danger">*</span></label> <select name="title"
                                    class="form-control form-control-sm @error('title') is-invalid @enderror ">
                                    <option value="">Select</option>
                                    <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                    <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                    <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                                </select>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>




                            <div class="col-md-3 mb-2 @error('first_name') is-invalid @enderror ">
                                <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    class="form-control form-control-sm @error('first_name') is-invalid @enderror"
                                    required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-3 mb-2 @error('middle_name') is-invalid @enderror">
                                <label class="form-label small">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                    class="form-control form-control-sm @error('middle_name') is-invalid @enderror ">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-2 @error('last_name') is-invalid @enderror">
                                <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="form-control form-control-sm" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2 @error('dob') is-invalid @enderror ">
                                <label class="form-label small">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="dob" value="{{ old('dob') }}"
                                    class="form-control form-control-sm">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2 @error('mother_name') is-invalid @enderror">
                                <label class="form-label small">Mother Name <span class="text-danger">*</span></label>
                                <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                    class="form-control form-control-sm" required>

                                @error('mother_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-4 mb-2 @error('guardian_name') is-invalid @enderror">
                                <label class="form-label small">Father / Spouse Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                                    class="form-control form-control-sm" required>

                                @error('guardian_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2 @error('mobile_number') is-invalid @enderror ">
                                <label class="form-label small">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile_number" value="{{ old('mobile_number') }}"
                                    class="form-control form-control-sm" maxlength="10" required>

                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2 @error('landline') is-invalid @enderror">
                                <label class="form-label small">Landline</label>
                                <input type="text" name="landline" value="{{ old('landline') }}"
                                    class="form-control form-control-sm">

                                @error('landline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-6 mb-2 @error('email') is-invalid @enderror">
                                <label class="form-label small">Email</label>
                                <input type="text" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-sm">

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2 @error('gas_consumer_number') is-invalid @enderror">
                                <label class="form-label small">Gas Consumer No</label>
                                <input type="text" name="gas_consumer_number"
                                    value="{{ old('gas_consumer_number') }}" class="form-control form-control-sm">
                                @error('gas_consumer_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">2. Address Details</h6>
                            </div>

                            <div class="col-md-4 mb-2 @error('house_flat_no') is-invlaid @enderror ">
                                <label class="form-label small">House / Flat No <span class="text-danger">*</span></label>
                                <input type="text" name="house_flat_no" value="{{ old('house_flat_no') }}"
                                    class="form-control form-control-sm" required>

                                @error('house_flat_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2 @error('street') is-invalid @enderror ">
                                <label class="form-label small">Street / Road <span class="text-danger">*</span></label>
                                <input type="text" name="street" value="{{ old('street') }}"
                                    class="form-control form-control-sm" required>

                                @error('street')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2 @error('landmark') is-invalid @enderror">
                                <label class="form-label small">Landmark</label>
                                <input type="text" name="landmark" value="{{ old('landmark') }}"
                                    class="form-control form-control-sm">

                                @error('landmark')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-2 @error('city') is-invalid @enderror ">
                                <label class="form-label small">City / Village <span class="text-danger">*</span></label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="form-control form-control-sm" required>

                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-2 @error('district') is-invalid @enderror ">
                                <label class="form-label small">District <span class="text-danger">*</span></label>
                                <input type="text" name="district" value="{{ old('district') }}"
                                    class="form-control form-control-sm" required>

                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-3 mb-2">
                                <label class="form-label small">
                                    State <span class="text-danger">*</span>
                                </label>

                                <select name="state"
                                    class="form-select form-select-sm @error('state') is-invalid @enderror" required>

                                    <option value="">-- Select State --</option>

                                    @foreach ($states as $state)
                                        <option value="{{ $state->name }}"
                                            {{ old('state') == $state->name ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-2 @error('pin_code') is-invalid @enderror ">
                                <label class="form-label small">Pin Code <span class="text-danger">*</span></label>
                                <input type="text" name="pin_code" value="{{ old('pin_code') }}"
                                    class="form-control form-control-sm" required>
                                @error('pin_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- ================= ID DETAILS ================= -->
                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">3. ID Details</h6>
                            </div>

                            <div class="col-md-6 mb-2 @error('id_number') is-invalid @enderror">
                                <label class="form-label small">ID Number</label>
                                <input type="text" name="id_number" value="{{ old('id_number') }}"
                                    class="form-control form-control-sm">

                                @error('id_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2 @error('ration_card_number') is-invalid @enderror ">
                                <label class="form-label small">Ration Card Number</label>
                                <input type="text" name="ration_card_number" value="{{ old('ration_card_number') }}"
                                    class="form-control form-control-sm">

                                @error('ration_card_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">4. Document & Photo Upload</h6>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Profile Image</label>
                                <div class="mt-2 py-2">
                                    <img id="imagePreview" class="rounded" width="60" height="70"
                                        alt="Current Photo" style="display:none;">
                                </div>
                                <input type="file" name="profile_image"
                                    class="form-control form-control-sm @error('profile_image') is-invalid @enderror"
                                    onchange="previewImage(event)">

                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">ID Image Front</label>
                                    <div class="mt-2 py-2">
                                        <img id="IDFrontPreview" class="rounded" width="60" height="70"
                                            alt="Current Photo" style="display:none;">
                                    </div>
                                    <input type="file" name="id_front_image"
                                        class="form-control form-control-sm @error('id_front_image') is-invalid @enderror"
                                        onchange="previewIDFrontImage(event)">

                                    @error('id_front_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">ID Image Back</label>
                                    <div class="mt-2 py-2">
                                        <img id="IDBackPreview" class="rounded" width="60" height="70"
                                            alt="Current Photo" style="display:none;">
                                    </div>
                                    <input type="file" name="id_back_image"
                                        class="form-control form-control-sm @error('id_back_image') is-invalid @enderror"
                                        onchange="previewIDBackImage(event)">

                                    @error('id_back_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>





                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Add Customer
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
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <!-- 1. Personal Details -->
                            <div class="col-12 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">1. Personal Details</h6>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">Title <span class="text-danger">*</span></label>
                                <select name="title" id="edit_title" class="form-control form-control-sm">
                                    <option value="">Select</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Ms">Ms</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="edit_first_name"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">Middle Name</label>
                                <input type="text" name="middle_name" id="edit_middle_name"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="edit_last_name"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="dob" id="edit_dob"
                                    class="form-control form-control-sm">
                            </div>


                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Mother Name <span class="text-danger">*</span></label>
                                <input type="text" name="mother_name" id="edit_mother_name"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Father / Spouse Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="guardian_name" id="edit_guardian_name"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile_number" id="edit_mobile_number"
                                    class="form-control form-control-sm" maxlength="10" required>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Landline</label>
                                <input type="text" name="landline" id="edit_landline"
                                    class="form-control form-control-sm">
                            </div>

                             <div class="col-md-6 mb-2">
                                <label class="form-label small">Email</label>
                                <input type="text" name="email" id="edit_email"
                                    class="form-control form-control-sm">
                            </div>


                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Gas Consumer No</label>
                                <input type="text" name="gas_consumer_number" id="edit_gas_consumer_number"
                                    class="form-control form-control-sm">
                            </div>


                            <!-- 2. Address Details -->
                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">2. Address Details</h6>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label class="form-label small">House / Flat No <span class="text-danger">*</span></label>
                                <input type="text" name="house_flat_no" id="edit_house_flat_no"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Street / Road <span class="text-danger">*</span></label>
                                <input type="text" name="street" id="edit_street"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Landmark</label>
                                <input type="text" name="landmark" id="edit_landmark"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">City / Village <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="edit_city" class="form-control form-control-sm"
                                    required>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">District <span class="text-danger">*</span></label>
                                <input type="text" name="district" id="edit_district"
                                    class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">
                                    State <span class="text-danger">*</span>
                                </label>

                                <select name="state" id="edit_state" class="form-select form-select-sm" required>

                                    <option value="">-- Select State --</option>

                                    @foreach ($states as $state)
                                        <option value="{{ $state->name }}"
                                            {{ old('state', $customer->state ?? '') == $state->name ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label small">Pin Code <span class="text-danger">*</span></label>
                                <input type="text" name="pin_code" id="edit_pin_code"
                                    class="form-control form-control-sm" required>
                            </div>



                            <!-- 3. ID Details -->
                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">3. ID Details</h6>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label small">ID Number</label>
                                <input type="text" name="id_number" id="edit_id_number"
                                    class="form-control form-control-sm">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Ration Card Number</label>
                                <input type="text" name="ration_card_number" id="edit_ration_card_number"
                                    class="form-control form-control-sm">
                            </div>


                            <div class="col-12 mt-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-1">4. Document & Photo Upload</h6>
                            </div>


                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Profile Image</label>

                                <div class="mt-2 py-2">
                                    <img id="edit_profile_preview" class="rounded" width="60" height="70"
                                        style="display:none;">
                                </div>

                                <input type="file" name="profile_image" id="edit_profile_image"
                                    class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">ID Front Image</label>

                                    <div class="mt-2 py-2">
                                        <img id="edit_id_front_preview" class="rounded" width="60" height="70"
                                            style="display:none;">
                                    </div>

                                    <input type="file" name="id_front_image" id="edit_id_front_image"
                                        class="form-control form-control-sm" accept="image/*">
                                </div>


                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">ID Back Image</label>

                                    <div class="mt-2 py-2">
                                        <img id="edit_id_back_preview" class="rounded" width="60" height="70"
                                            style="display:none;">
                                    </div>

                                    <input type="file" name="id_back_image" id="edit_id_back_image"
                                        class="form-control form-control-sm" accept="image/*">
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Customer</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('script')
    <script>
        document.querySelectorAll('.editCustomerBtn').forEach(button => {
            button.addEventListener('click', function() {

                const data = this.dataset;

                let id = data.id;
                console.log(id);
                let updateUrl = "{{ route('customers.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', id);
                document.getElementById('editForm').action = updateUrl;

                // Personal Details
                document.getElementById('edit_title').value = data.title;
                document.getElementById('edit_first_name').value = data.first_name;
                document.getElementById('edit_middle_name').value = data.middle_name;
                document.getElementById('edit_last_name').value = data.last_name;
                document.getElementById('edit_dob').value = data.dob;
                document.getElementById('edit_gas_consumer_number').value = data.gas_consumer_number;
                document.getElementById('edit_guardian_name').value = data.guardian_name;
                document.getElementById('edit_mother_name').value = data.mother_name;

                // Address Details
                document.getElementById('edit_house_flat_no').value = data.house_flat_no;
                document.getElementById('edit_street').value = data.street;
                document.getElementById('edit_landmark').value = data.landmark;
                document.getElementById('edit_city').value = data.city;
                document.getElementById('edit_district').value = data.district;
                document.getElementById('edit_state').value = data.state;
                document.getElementById('edit_pin_code').value = data.pin_code;
                document.getElementById('edit_mobile_number').value = data.mobile_number;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_landline').value = data.landline;

                // ID Details
                document.getElementById('edit_id_number').value = data.id_number;
                document.getElementById('edit_ration_card_number').value = data.ration_card_number;




                const profilePreview = document.getElementById('edit_profile_preview');
                if (data.profile_image) {
                    profilePreview.src = "{{ asset('storage') }}/" + data.profile_image;
                    profilePreview.style.display = 'block';
                } else {
                    profilePreview.style.display = 'none';
                }


                const idFrontPreview = document.getElementById('edit_id_front_preview');
                if (data.id_front_image) {
                    idFrontPreview.src = "{{ asset('storage') }}/" + data.id_front_image;
                    idFrontPreview.style.display = 'block';
                } else {
                    idFrontPreview.style.display = 'none';
                }


                const idBackPreview = document.getElementById('edit_id_back_preview');
                if (data.id_back_image) {
                    idBackPreview.src = "{{ asset('storage') }}/" + data.id_back_image;
                    idBackPreview.style.display = 'block';
                } else {
                    idBackPreview.style.display = 'none';
                }
            });
        });
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
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewIDFrontImage(event) {
            const input = event.target;
            const preview = document.getElementById('IDFrontPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewIDBackImage(event) {
            const input = event.target;
            const preview = document.getElementById('IDBackPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function livePreview(inputId, previewId) {

            document.getElementById(inputId).addEventListener('change', function() {

                const file = this.files[0];
                const preview = document.getElementById(previewId);

                if (file && file.type.startsWith('image/')) {

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                }
            });
        }


        livePreview('edit_profile_image', 'edit_profile_preview');
        livePreview('edit_id_front_image', 'edit_id_front_preview');
        livePreview('edit_id_back_image', 'edit_id_back_preview');
    </script>
@endsection
@endsection
