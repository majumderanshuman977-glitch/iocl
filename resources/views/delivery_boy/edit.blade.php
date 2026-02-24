@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h4>Delivery Boy Details</h4>
                    <h6>Edit Delivery Boy</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('delivery-boy.update', $deliveryBoy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <input type="hidden" name="van_type" value="{{ $deliveryBoy->van_type }}">

                            @if ($deliveryBoy->van_type === 'large_van')
                                {{-- vehicle name --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vehicle Name</label>
                                        <input type="text" name="vehicle_name" class="form-control"
                                            value="{{ old('vehicle_name', $deliveryBoy->vehicle_name) }}">

                                        @error('vehicle_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- vehicle number --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vehicle Number</label>
                                        <input type="text" name="vehicle_number" class="form-control"
                                            value="{{ old('vehicle_number', $deliveryBoy->vehicle_number) }}">
                                        @error('vehicle_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- driver name --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Driver Name</label>
                                        <input type="text" name="driver_name" class="form-control"
                                            value="{{ old('driver_name', $deliveryBoy->driver_name) }}">
                                    </div>

                                    @error('driver_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- mobile --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" name="mobile_number" class="form-control"
                                            value="{{ old('mobile_number', $deliveryBoy->mobile_number) }}">
                                        @error('mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                {{-- capacity --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Max Cylinder Capacity</label>
                                        <input type="text" name="max_cylinder_capacity" class="form-control"
                                            value="{{ old('max_cylinder_capacity', $deliveryBoy->max_cylinder_capacity) }}">
                                        @error('max_cylinder_capacity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                {{-- van boy name --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Van Boy Name</label>
                                        <input type="text" name="driver_name" class="form-control"
                                            value="{{ old('driver_name', $deliveryBoy->driver_name) }}">
                                        @error('driver_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- mobile --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mobile Numb er</label>
                                        <input type="text" name="mobile_number" class="form-control"
                                            value="{{ old('mobile_number', $deliveryBoy->mobile_number) }}" maxlength="10">
                                        @error('mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>PF / ESI Applicable <span class="text-danger">*</span></label>
                                        <select name="is_pf_esi" id="is_pf_esi" class="form-control">
                                            <option value="">Select Option</option>
                                            <option value="1"
                                                {{ old('is_pf_esi', $deliveryBoy->is_pf_esi ?? '') == 1 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="0"
                                                {{ old('is_pf_esi', $deliveryBoy->is_pf_esi ?? '') == 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>

                                        @error('is_pf_esi')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>PF/ESI (%)</label>
                                        <input type="text" name="pf_esi_percentage" id="pf_esi_percentage"
                                            class="form-control"
                                            value="{{ old('pf_esi_percentage', $deliveryBoy->pf_esi_percentage ?? '0.00') }}"
                                            placeholder="0.00">

                                        @error('pf_esi_percentage')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Max Cylinder Capacity</label>
                                        <input type="text" name="max_cylinder_capacity_small" class="form-control"
                                            value="{{ old('max_cylinder_capacity_small', $deliveryBoy->max_cylinder_capacity) }}">
                                        @error('max_cylinder_capacity_small')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Update Delivery Boy
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
@section('script')
    <script>
        $(document).ready(function() {
            // Toggle fields based on van type
            function toggleVanFields() {
                const vanType = $('#van_type').val();

                if (vanType === 'large_van') {
                    $('#large_van_fields').show();
                    $('#small_van_fields').hide();

                    // Enable large van fields
                    $('#vehicle_name, #vehicle_number, #large_driver_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', true);

                    // Disable small van fields
                    $('#small_driver_name, #small_mobile_number, #is_pf_esi').prop('required', false);

                } else if (vanType === 'small_van') {
                    $('#large_van_fields').hide();
                    $('#small_van_fields').show();

                    // Disable large van fields
                    $('#vehicle_name, #vehicle_number, #large_driver_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', false);

                    // Enable small van fields
                    $('#small_driver_name, #small_mobile_number, #is_pf_esi').prop('required', true);

                } else {
                    $('#large_van_fields').hide();
                    $('#small_van_fields').hide();

                    // Disable all fields
                    $('#vehicle_name, #vehicle_number, #large_driver_name, #large_mobile_number, #max_cylinder_capacity')
                        .prop('required', false);
                    $('#small_driver_name, #small_mobile_number, #is_pf_esi').prop('required', false);
                }
            }

            // Toggle van fields on type change
            $('#van_type').on('change', toggleVanFields);

            // Toggle PF/ESI percentage based on selection
            $('#is_pf_esi').on('change', function() {
                if ($(this).val() === '1') {

                    // If Yes, enable field and set to 12.50
                    $('#pf_esi_percentage').prop('readonly', false);
                    $('#pf_esi_percentage').val('12.5');
                } else {
                    // If No, disable field and set to 0.00
                    $('#pf_esi_percentage').prop('readonly', false);
                    $('#pf_esi_percentage').val('0.00');
                }
            });

            // Initialize on page load
            toggleVanFields();

            // Set initial PF/ESI percentage
            if ($('#is_pf_esi').val() === '1') {

                // $('#pf_esi_percentage').val('12.5');
                $('#pf_esi_percentage').prop('readonly', false);
            } else {
                $('#pf_esi_percentage').val('0.00');
                $('#pf_esi_percentage').prop('readonly', false);
            }

            // Mobile number validation (only numbers)
            $('#large_mobile_number, #small_mobile_number').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    return false;
                }
            });

            // Vehicle number uppercase
            $('#vehicle_number').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            // Capacity validation (positive numbers)
            $('#max_cylinder_capacity').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    return false;
                }
            });
        });
    </script>
@endsection
@endsection
