<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use Illuminate\Http\Request;

class DeliveryBoyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_delivery_boys')->only(['index']);

        $this->middleware('permission:create_delivery_boys')
            ->only(['create', 'store']);

        $this->middleware('permission:edit_delivery_boys')
            ->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $query = DeliveryBoy::query()->with('creator');


        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('vehicle_name', 'like', '%' . $request->name . '%')
                    ->orWhere('mobile_number', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('van_type')) {
            $query->where('van_type', $request->van_type);
        }


        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }

        $deliveryBoy = $query->orderBy('created_at', 'DESC')->paginate(10)->withQueryString();

        return view('delivery_boy.list', compact('deliveryBoy'));
    }


    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'vehicle_type' => 'required',

            'vehicle_name' => 'nullable|string',
            'large_mobile_number' => 'required_if:vehicle_type,LARGE_VAN|max:10|unique:delivery_boys,mobile_number',
            'small_mobile_number' => 'required_if:vehicle_type,SMALL_VAN|max:10|unique:delivery_boys,mobile_number',
            'vehicle_number' => 'nullable|string',
            'driver_owner_name' => 'nullable|string',
            'van_boy_name' => 'nullable|string',
            'max_cylinder_capacity' => 'required_if:vehicle_type,LARGE_VAN|nullable',
            'max_cylinder_capacity_small' => 'required_if:vehicle_type,SMALL_VAN|nullable',
            'pf_esi_applicable' => 'nullable|boolean',
            'pf_esi_percentage' => 'nullable|string',
        ], [
            'vehicle_name.required' => 'The vehicle name field is required.',
            'large_mobile_number.required_if' => 'The mobile number field is required.',
            'large_mobile_number.max' => 'Mobile number must not exceed 10 characters.',
            'small_mobile_number.required_if' => 'The mobile number field is required.',
            'large_mobile_number.unique' => 'The mobile number has already been taken.',
            'small_mobile_number.max' => 'Mobile number must not exceed 10 characters.',
            'small_mobile_number.unique' => 'The mobile number has already been taken.',
            'max_cylinder_capacity.required_if' => 'The max cylinder capacity field is required.',
            'max_cylinder_capacity_small.required_if' => 'The max cylinder capacity field is required.',
        ]);



        $vehicle_type = $request->vehicle_type;

        if ($vehicle_type === 'LARGE_VAN') {
            $deliveryBoy = new DeliveryBoy();
            $deliveryBoy->van_type = $vehicle_type;
            $deliveryBoy->vehicle_name = $request->vehicle_name;
            $deliveryBoy->vehicle_number = $request->vehicle_number;
            $deliveryBoy->driver_name = $request->driver_owner_name;
            $deliveryBoy->mobile_number = $request->large_mobile_number;
            $deliveryBoy->max_cylinder_capacity = $request->max_cylinder_capacity;
            $deliveryBoy->status = true;
            $deliveryBoy->created_by = $user->id;
            $deliveryBoy->save();
        }

        if ($vehicle_type === 'SMALL_VAN') {
            $deliveryBoy = new DeliveryBoy();
            $deliveryBoy->van_type = $vehicle_type;
            $deliveryBoy->driver_name = $request->van_boy_name;
            $deliveryBoy->mobile_number = $request->small_mobile_number;
            $deliveryBoy->is_pf_esi = $request->pf_esi_applicable;
            $deliveryBoy->pf_esi_percentage = $request->pf_esi_applicable ? '12.50' : null;
            $deliveryBoy->status = true;
            $deliveryBoy->created_by = $user->id;
            $deliveryBoy->max_cylinder_capacity = $request->max_cylinder_capacity_small;
            $deliveryBoy->save();
        }
        return redirect()->route('delivery-boy.list')->with('success', 'Delivery Boy created successfully.');
    }

    public function create()
    {
        return view('delivery_boy.create');
    }


    public function edit($id)
    {
        $deliveryBoy = DeliveryBoy::findOrFail($id);

        return view('delivery_boy.edit', compact('deliveryBoy'));
    }


    public function update(Request $request, $id)
    {
        $deliveryBoy = DeliveryBoy::findOrFail($id);


        $rules = [
            'driver_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:10|unique:delivery_boys,mobile_number,' . $id,
            'van_type' => 'required'
        ];



        if ($request->van_type === 'large_van') {
            $rules['vehicle_name'] = 'required|string|max:255';
            $rules['vehicle_number'] = 'required|string|max:50';
            $rules['max_cylinder_capacity'] = 'required|numeric';
        } else {
            $rules['is_pf_esi'] = 'required|boolean';
            $rules['pf_esi_percentage'] = 'nullable';
            $rules['max_cylinder_capacity_small'] = 'required|numeric';
        }

        $validated = $request->validate($rules);


        if ($request->van_type === 'large_van') {
            $deliveryBoy->van_type = $request->van_type;
            $deliveryBoy->vehicle_name = $request->vehicle_name;
            $deliveryBoy->vehicle_number = $request->vehicle_number;
            $deliveryBoy->driver_name = $request->driver_name;
            $deliveryBoy->mobile_number = $request->mobile_number;
            $deliveryBoy->max_cylinder_capacity = $request->max_cylinder_capacity;
        }
        if ($request->van_type === 'small_van') {
            $deliveryBoy->van_type = $request->van_type;
            $deliveryBoy->driver_name = $request->driver_name;
            $deliveryBoy->mobile_number = $request->mobile_number;
            $deliveryBoy->is_pf_esi = $request->is_pf_esi;
            $deliveryBoy->pf_esi_percentage = $request->is_pf_esi == 1
                ? $request->pf_esi_percentage
                : null;
            $deliveryBoy->max_cylinder_capacity = $request->max_cylinder_capacity_small;
        }

        $deliveryBoy->save();

        return redirect()
            ->route('delivery-boy.list')
            ->with('success', 'Delivery Boy updated successfully.');
    }

    // public function destroy($id){
    //        $deliveryBoy = DeliveryBoy::find($id);
    //        $deliveryBoy->delete();
    //       return response()->json([
    //         'status' => true,
    //         'message' => 'Delivery Boy deleted successfully'
    //     ]);
    // }


    public function updateStatus(Request $request)
    {
        $deliveryBoy = DeliveryBoy::findOrFail($request->id);
        $deliveryBoy->status = $request->status;
        $deliveryBoy->save();

        return response()->json([
            'success' => true,
            'message' => 'Delivery Boy status updated successfully'
        ]);
    }
}
