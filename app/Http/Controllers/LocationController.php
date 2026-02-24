<?php

namespace App\Http\Controllers;

use App\Models\CylinderCategories;
use App\Models\Location;
use App\Models\LocationCylinderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_location')->only(['index']);

        $this->middleware('permission:create_location')
            ->only(['create','store']);

        $this->middleware('permission:edit_location')
            ->only(['edit', 'update']);
    }

    public function index(Request $request)
    {

        $query = Location::query()->with('creator');

        if ($request->filled('name')) {
            $query->where('location_name', 'like', '%' . $request->name . '%');
        }

        $locations = $query->with('locationCylinderCategories.category')->latest()->paginate(10)->withQueryString();
        // $locations = Location::with('locationCylinderCategories.category')->latest()->get();

        return view('location.index', compact('locations'));
    }


    public function create(Request $request)
    {
        $cylinder_categories = CylinderCategories::where('status', 1)->orderBy('id', 'desc')->get();

        return view('location.create', compact('cylinder_categories'));
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'location_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cylinder_categories' => 'required|array',
            'cylinder_categories.*.category_id' => 'required|exists:cylinder_categories,id',
            'cylinder_categories.*.price' => 'required|numeric',
        ], [
            'cylinder_categories.required' => 'Please select at least one cylinder category.',
            'cylinder_categories.*.category_id.required' => 'Please select a valid cylinder category.',
            'cylinder_categories.*.price.required' => 'Please enter a price for the cylinder category.',
            'cylinder_categories.*.price.numeric' => 'The price must be a valid number.',

        ]);
        // dd($request->all());

        DB::beginTransaction();
        try {
            $location = new Location();
            $location->location_name = $request->location_name;
            $location->address = $request->address;
            $location->created_by = $user->id;
            $location->save();
            foreach ($request->cylinder_categories as $category) {
                LocationCylinderCategory::insert([
                    'location_id' => $location->id,
                    'cylinder_category_id' => $category['category_id'],
                    'price' => $category['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the location: ' . $e->getMessage());
        }


        return redirect()->route('location.list')
            ->with('success', 'Location created successfully.');
    }

    public function edit($id)
    {
        $location = Location::with('locationCylinderCategories.category')->findOrFail($id);
        $cylinder_categories = CylinderCategories::orderBy('id', 'desc')->get();

        return view('location.edit', compact('location', 'cylinder_categories'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $request->validate([
            'location_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'cylinder_categories' => 'required|array',
            'cylinder_categories.*.category_id' => 'required|exists:cylinder_categories,id',
            'cylinder_categories.*.price' => 'required|numeric',
        ], [
            'cylinder_categories.required' => 'Please select at least one cylinder category.',
            'cylinder_categories.*.category_id.required' => 'Please select a valid cylinder category.',
            'cylinder_categories.*.price.required' => 'Please enter a price for the cylinder category.',
            'cylinder_categories.*.price.numeric' => 'The price must be a valid number.',

        ]);

        DB::beginTransaction();
        try {
            $location = Location::findOrFail($id);
            $location->location_name = $request->location_name;
            $location->address = $request->address;
            $location->created_by = $user->id;
            $location->created_at = now();
            $location->save();

            LocationCylinderCategory::where('location_id', $id)->delete();

            foreach ($request->cylinder_categories as $category) {
                LocationCylinderCategory::insert([
                    'location_id' => $location->id,
                    'cylinder_category_id' => $category['category_id'],
                    'price' => $category['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the location: ' . $e->getMessage());
        }

        return redirect()->route('location.list')
            ->with('success', 'Location updated successfully');
    }
}
