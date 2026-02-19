<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

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
            $query->where('customer_name', 'like', '%' . $request->name . '%')
                ->orWhere('mobile_number', 'like', '%' . $request->name . '%')
                ->orWhere('address', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $customers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('customer.index', compact('customers'));
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
            'customer_name' => 'required|string',
            'mobile_number' => 'required|numeric',
            'address' => 'required|string',
            'id_file' => 'nullable',
            'id_number' => 'nullable|string',
        ], [
            'customer_name.required' => 'The customer name field is required.',
            'mobile_number.required' => 'The mobile number field is required.',
            'mobile_number.numeric' => 'The mobile number field should be numeric',
            'address.required' => 'The address field is required.',
        ]);

        $customers = new Customers();
        $customers->customer_name = $request->customer_name;
        $customers->mobile_number = $request->mobile_number;
        $customers->address = $request->address;
        $customers->id_proof_number = $request->id_number;
        $customers->created_by = $user->id;
        $customers->save();

        if ($request->hasFile('id_file')) {
            $imagePath = $request->file('id_file')->store('customers', 'public');
            $customers->id_proof = $imagePath;
            $customers->save();
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'customer_name' => 'required|string',
            'mobile_number' => 'required|numeric',
            'address'       => 'required|string',
            'id_file'       => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'id_number'     => 'nullable|string',
        ], [
            'customer_name.required' => 'The customer name field is required.',
            'mobile_number.required' => 'The mobile number field is required.',
            'mobile_number.numeric' => 'The mobile number field should be numeric',
            'address.required'       => 'The address field is required.',
        ]);

        $customer = Customers::findOrFail($id);

        $customer->customer_name   = $request->customer_name;
        $customer->mobile_number   = $request->mobile_number;
        $customer->address         = $request->address;
        $customer->id_proof_number = $request->id_number;

        if ($request->hasFile('id_file')) {


            if ($customer->id_proof && file_exists(public_path('storage/' . $customer->id_proof))) {
                unlink(public_path('storage/' . $customer->id_proof));
            }


            $customer->id_proof = $request->file('id_file')->store('customers', 'public');
        }

        $customer->save();

        return redirect()->back()->with('success', 'Customer updated successfully.');
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
