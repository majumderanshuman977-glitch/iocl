<?php

namespace App\Http\Controllers;

use App\Models\ProductLogs;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_products')->only(['index']);

        $this->middleware('permission:create_products')
            ->only(['create', 'store']);

        $this->middleware('permission:edit_products')
            ->only(['edit', 'update']);
    }


    public function index(Request $request)
    {

        $query = Products::query()->with('creator');


        if ($request->filled('name')) {
            $query->where('product_name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('date_range')) {

            $dates = explode(' to ', $request->date_range);

            if (count($dates) == 2) {
                $start = $dates[0];
                $end = $dates[1];

                $query->whereBetween('created_at', [
                    $start . ' 00:00:00',
                    $end . ' 23:59:59'
                ]);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('products.list', compact('products'));
    }



    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'product_name' => 'required|string|unique:products,product_name',
            'price' => 'nullable',
            'quantity' => 'nullable|numeric',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ], [
            'product_name.required' => 'Product name is required',
            'product_name.unique' => 'Product name already exists',
        ]);


        DB::transaction(function () use ($request) {
            $user = auth()->user();
            $product = new Products();
            $product->product_name = $request->product_name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->created_by = $user->id;
            $product->save();

            if ($request->hasFile('product_image')) {
                $product->product_image = $request->file('product_image')->store('products', 'public');
                $product->save();
            }

            if ($product) {
                $product_logs = new ProductLogs();
                $product_logs->product_id = $product->id;
                $product_logs->product_name = $product->product_name;
                $product_logs->quantity = $product->quantity;
                $product_logs->transaction_type = 'add';
                $product_logs->transaction_date = now()->toDateString();
                $product_logs->remark = 'Product created';
                $product_logs->save();
            }
        });



        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {


        $product = Products::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $id,
            'price' => 'nullable',
            'description' => 'nullable|string',
        ], [
            'product_name.unique' => 'The product name has already been taken.',

        ]);

        $product = Products::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('products.list')
            ->with('success', 'Product updated successfully');
    }


    public function updateStatus(Request $request)
    {

        $product = Products::find($request->id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully'
        ]);
    }


    public function updateStock(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $type = $request->type;
            $transaction_date = $request->date;

            $product = Products::findOrFail($id);

            if (($type == 'remove') && $product->quantity < $request->quantity) {
                return redirect()->route('products.list')
                    ->with('error', 'Product stock is not enough.');
            }

            $product->quantity = $type == 'add'
                ? $product->quantity + $request->quantity
                : $product->quantity - $request->quantity;

            $product->save();

            $product_logs = new ProductLogs();
            $product_logs->product_id = $product->id;
            $product_logs->product_name = $product->product_name;
            $product_logs->quantity = $request->quantity;
            $product_logs->transaction_type = $type;
            $product_logs->transaction_date = $transaction_date;
            $product_logs->remark = $request->remark ?? '';
            $product_logs->save();

            DB::commit();

            return redirect()->route('products.list')
                ->with('success', 'Product stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('products.list')
                ->with('error', 'An error occurred while updating product stock.');
        }
    }
}
