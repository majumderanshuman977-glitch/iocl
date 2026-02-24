<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_customers')->only(['index']);

        $this->middleware('permission:create_customers')
            ->only(['create', 'store']);

        $this->middleware('permission:edit_customers')
            ->only(['edit', 'update']);
    }
    public function index(Request $request)
    {
        // $customers = Customers::with('creator')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $query = Customers::query()->with('creator');
        if ($request->filled('name')) {
            $query->where('first_name', 'like', '%' . $request->name . '%')
                ->orWhere('middle_name', 'like', '%' . $request->name . '%')
                ->orWhere('last_name', 'like', '%' . $request->name . '%')
                ->orWhere('mobile_number', 'like', '%' . $request->name . '%')
                ->orWhere('house_flat_no', 'like', '%' . $request->name . '%')
                ->orWhere('street', 'like', '%' . $request->name . '%')
                ->orWhere('landmark', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $states = State::orderBy('name')->get();
        $customers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('customer.index', compact('customers', 'states'));
    }

    public function edit($id)
    {
        $customer = Customers::findOrFail($id);
        return response()->json($customer);
    }



    public function store(Request $request)
    {


        $user = auth()->user();

        $request->validate([
            'title' => 'required',
            'first_name' => 'required|string',
            'middle_name' => 'nullable',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'email' => 'nullable',
            'gas_consumer_number' => 'nullable',
            'guardian_name' => 'required',
            'mother_name' => 'required',
            'house_flat_no' => 'required',
            'street' => 'nullable',
            'landmark' => 'nullable',
            'city' => 'nullable',
            'district' => 'nullable',
            'state' => 'nullable',
            'pin_code' => 'required',
            'mobile_number' => 'required|digits:10|unique:customers,mobile_number',
            'landline' => 'nullable',
            'id_number' => 'required',
            'ration_card_number' => 'nullable',
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'id_back_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'id_front_image' => 'nullable|image|mimes:png,jpg,jpeg',
        ], [
            'mobile_number.required' => 'Mobile Number should not be more than 10 digits',
            'id_number.required' => 'Need valid ID proof'

        ]);

        $customers = new Customers();
        $customers->title = $request->title;
        $customers->first_name = $request->first_name;
        $customers->middle_name = $request->middle_name;
        $customers->last_name = $request->last_name;
        $customers->dob = $request->dob;
        $customers->gas_consumer_number = $request->gas_consumer_number;
        $customers->father_spouse_name = $request->guardian_name;
        $customers->mother_name = $request->mother_name;
        $customers->house_flat_no = $request->house_flat_no;
        $customers->street = $request->street;
        $customers->landmark = $request->landmark;
        $customers->city = $request->city;
        $customers->district = $request->district;
        $customers->state = $request->state;
        $customers->pin_code = $request->pin_code;
        $customers->mobile_number = $request->mobile_number;
        $customers->landline = $request->landline;
        $customers->email = $request->email;
        $customers->id_number = $request->id_number;
        $customers->ration_card_number = $request->ration_card_number;
        $customers->status = true;
        $customers->created_by = $user->id;
        $customers->save();

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('customers', 'public');
            $customers->profile_image = $imagePath;
            $customers->save();
        }


        if ($request->hasFile('id_front_image')) {

            $frontImage = $request->file('id_front_image');

            $frontImageName = 'front_' . time() . '_' . uniqid() . '.' . $frontImage->getClientOriginalExtension();

            $frontImage->storeAs('customer_id_image', $frontImageName, 'public');

            $customers->id_front_image = 'customer_id_image/' . $frontImageName;
        }

        if ($request->hasFile('id_back_image')) {

            $backImage = $request->file('id_back_image');

            $backImageName = 'back_' . time() . '_' . uniqid() . '.' . $backImage->getClientOriginalExtension();

            $backImage->storeAs('customer_id_image', $backImageName, 'public');

            $customers->id_back_image = 'customer_id_image/' . $backImageName;
        }

        $customers->save();

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }




    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'first_name' => 'required|string',
            'middle_name' => 'nullable',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'email' => 'nullable',
            'gas_consumer_number' => 'nullable',
            'guardian_name' => 'required',
            'mother_name' => 'required',
            'house_flat_no' => 'required',
            'street' => 'nullable',
            'landmark' => 'nullable',
            'city' => 'nullable',
            'district' => 'nullable',
            'state' => 'nullable',
            'pin_code' => 'required',
            'mobile_number' => 'required|digits:10|unique:customers,mobile_number,' . $id,
            'landline' => 'nullable',
            'id_number' => 'required',
            'ration_card_number' => 'nullable',
            'profile_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'id_front_image' => 'nullable|image|mimes:png,jpg,jpeg',
            'id_back_image' => 'nullable|image|mimes:png,jpg,jpeg'
        ], [
            'mobile_number.required' => 'Mobile Number should not be more than 10 digits',
            'id_number.required' => 'Need valid ID proof'
        ]);


        $customer = Customers::find($id);
        $customer->title = $request->title;
        $customer->first_name = $request->first_name;
        $customer->middle_name = $request->middle_name;
        $customer->last_name = $request->last_name;
        $customer->dob = $request->dob;
        $customer->email = $request->email;
        $customer->gas_consumer_number = $request->gas_consumer_number;
        $customer->father_spouse_name = $request->guardian_name;
        $customer->mother_name = $request->mother_name;
        $customer->house_flat_no = $request->house_flat_no;
        $customer->street = $request->street;
        $customer->landmark = $request->landmark;
        $customer->city = $request->city;
        $customer->district = $request->district;
        $customer->state = $request->state;
        $customer->pin_code = $request->pin_code;
        $customer->mobile_number = $request->mobile_number;
        $customer->landline = $request->landline;
        $customer->id_number = $request->id_number;
        $customer->ration_card_number = $request->ration_card_number;


        if ($request->hasFile('profile_image')) {


            if ($customer->profile_image && Storage::disk('public')->exists($customer->profile_image)) {
                Storage::disk('public')->delete($customer->profile_image);
            }


            $imagePath = $request->file('profile_image')->store('customers', 'public');
            $customer->profile_image = $imagePath;
        }

        if ($request->hasFile('id_front_image')) {


            if (
                $customer->id_front_image &&
                Storage::disk('public')->exists($customer->id_front_image)
            ) {

                Storage::disk('public')->delete($customer->id_front_image);
            }

            $frontImage = $request->file('id_front_image');

            $frontImageName = 'front_' . time() . '_' . uniqid() . '.' .
                $frontImage->getClientOriginalExtension();

            $frontImage->storeAs('customer_id_image', $frontImageName, 'public');

            $customer->id_front_image = 'customer_id_image/' . $frontImageName;
        }


        if ($request->hasFile('id_back_image')) {

          
            if (
                $customer->id_back_image &&
                Storage::disk('public')->exists($customer->id_back_image)
            ) {

                Storage::disk('public')->delete($customer->id_back_image);
            }

            $backImage = $request->file('id_back_image');

            $backImageName = 'back_' . time() . '_' . uniqid() . '.' .
                $backImage->getClientOriginalExtension();

            $backImage->storeAs('customer_id_image', $backImageName, 'public');

            $customer->id_back_image = 'customer_id_image/' . $backImageName;
        }

        $customer->save();

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }


    public function customerStatusUpdate(Request $request)
    {
        $customers = Customers::findOrFail($request->id);
        $customers->status = $request->status;
        $customers->save();

        return response()->json([
            'success' => true,
            'message' => 'Customer status updated successfully'
        ]);
    }
}
