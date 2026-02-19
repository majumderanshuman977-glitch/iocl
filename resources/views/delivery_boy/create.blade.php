@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Delivery Boy Management</h4>
                    <h6>Add Delivery Boy</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('delivery-boy.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">


                            <div class="col-lg-3 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Vehicle Type <span class="text-danger">*</span></label>
                                    <select name="vehicle_type" id="vehicle_type" class="form-control">
                                        <option value="">Select Vehicle Type</option>
                                        <option value="LARGE_VAN"
                                            {{ old('vehicle_type') == 'LARGE_VAN' ? 'selected' : '' }}>
                                            Large Van
                                        </option>
                                        <option value="SMALL_VAN"
                                            {{ old('vehicle_type') == 'SMALL_VAN' ? 'selected' : '' }}>
                                            Small Van
                                        </option>
                                    </select>
                                    @error('vehicle_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Large Van Fields -->
                            <div id="large_van_fields" class="col-lg-12" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vehicle Name <span class="text-danger">*</span></label>
                                            <input type="text" name="vehicle_name" id="vehicle_name" class="form-control"
                                                value="{{ old('vehicle_name') }}" placeholder="Enter vehicle name">
                                            @error('vehicle_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vehicle Number <span class="text-danger">*</span></label>
                                            <input type="text" name="vehicle_number" id="vehicle_number"
                                                class="form-control" value="{{ old('vehicle_number') }}"
                                                placeholder="e.g., KA-01-AB-1234" style="text-transform: uppercase;">
                                            @error('vehicle_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Driver Name <span class="text-danger">*</span></label>
                                            <input type="text" name="driver_owner_name" id="driver_owner_name"
                                                class="form-control" value="{{ old('driver_owner_name') }}"
                                                placeholder="Enter driver/owner name">
                                            @error('driver_owner_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" name="large_mobile_number" id="large_mobile_number"
                                                class="form-control" value="{{ old('large_mobile_number') }}"
                                                placeholder="Enter 10 digit mobile number" maxlength="15">
                                            @error('large_mobile_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Max Cylinder Capacity <span class="text-danger">*</span></label>
                                            <input type="number" name="max_cylinder_capacity" id="max_cylinder_capacity"
                                                class="form-control" value="{{ old('max_cylinder_capacity') }}"
                                                placeholder="Enter capacity" min="1">
                                            @error('max_cylinder_capacity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Small Van Fields -->
                            <div id="small_van_fields" class="col-lg-12" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Van Boy Name <span class="text-danger">*</span></label>
                                            <input type="text" name="van_boy_name" id="van_boy_name" class="form-control"
                                                value="{{ old('van_boy_name') }}" placeholder="Enter van boy name">
                                            @error('van_boy_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" name="small_mobile_number" id="small_mobile_number"
                                                class="form-control" value="{{ old('small_mobile_number') }}"
                                                placeholder="Enter 10 digit mobile number" maxlength="15">
                                            @error('small_mobile_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>PF / ESI Applicable <span class="text-danger">*</span></label>
                                            <select name="pf_esi_applicable" id="pf_esi_applicable" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="1"
                                                    {{ old('pf_esi_applicable') == '1' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="0"
                                                    {{ old('pf_esi_applicable') == '0' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                            @error('pf_esi_applicable')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>PF / ESI (%)</label>
                                            <input type="number" name="pf_esi_percentage" id="pf_esi_percentage"
                                                class="form-control" value="{{ old('pf_esi_percentage', '12.5') }}"
                                                placeholder="12.5" step="0.01" min="0" max="100">

                                            @error('pf_esi_percentage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- Buttons -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Submit
                                </button>
                                <a href="{{ route('delivery-boy.list') }}" class="btn btn-cancel">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function toggleVehicleFields() {
                const vehicleType = $('#vehicle_type').val();

                if (vehicleType === 'LARGE_VAN') {
                    $('#large_van_fields').show();
                    $('#small_van_fields').hide();


                    $('#vehicle_name, #vehicle_number, #driver_owner_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', true);


                    $('#van_boy_name, #small_mobile_number, #pf_esi_applicable').prop('required', false);

                } else if (vehicleType === 'SMALL_VAN') {
                    $('#large_van_fields').hide();
                    $('#small_van_fields').show();


                    $(
                    '#vehicle_name, #vehicle_number, #driver_owner_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', false);
                    $('#van_boy_name, #small_mobile_number, #pf_esi_applicable').prop('required', true);
                    // .prop('required', false);


                    $('#van_boy_name, #small_mobile_number, #pf_esi_applicable').prop('required', true);
                    //

                } else {
                    $('#large_van_fields').hide();
                    $('#small_van_fields').hide();


                    $('#vehicle_name, #vehicle_number, #driver_owner_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', false);
                    $('#van_boy_name, #small_mobile_number, #pf_esi_applicable').prop('required', false);
                }
            }


            $('#vehicle_type').on('change', toggleVehicleFields);


            $('#pf_esi_applicable').on('change', function() {
                if ($(this).val() === '1') {
                    $('#pf_esi_percentage').prop('readonly', false);
                    $('#pf_esi_percentage').val('12.5');
                } else {
                    $('#pf_esi_percentage').prop('readonly', false);
                    $('#pf_esi_percentage').val('0.00');
                }
            });

            // Initialize on page load (for validation errors)
            toggleVehicleFields();

            // Set PF/ESI percentage on load if applicable
            if ($('#pf_esi_applicable').val() === '0') {
                $('#pf_esi_percentage').val('0.00');
            }

            // Mobile number validation (only numbers)
            $('#large_mobile_number, #small_mobile_number').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    return false;
                }
            });

            // Vehicle number uppercase conversion
            $('#vehicle_number').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Capacity validation (positive numbers only)
            $('#max_cylinder_capacity').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    return false;
                }
            });
        });
    </script>
@endsection
