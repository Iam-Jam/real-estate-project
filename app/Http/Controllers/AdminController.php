<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
 

    /**
     * Display a listing of the properties.
     *
     * @return \Illuminate\View\View
     */
    public function propertiesIndex()
    {
        $properties = $this->propertyService->getAllProperties();
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     *
     * @return \Illuminate\View\View
     */
    public function propertiesCreate()
    {
        return view('admin.properties.create');
    }

    /**
     * Store a newly created property in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function propertiesStore(PropertyRequest $request)
    {
        try {
            $property = $this->propertyService->createProperty($request->validated());

            Log::info('Property created successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create property', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to create property. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View
     */
    public function propertiesEdit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function propertiesUpdate(PropertyRequest $request, Property $property)
    {
        try {
            $this->propertyService->updateProperty($property, $request->validated());

            Log::info('Property updated successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update property', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update property. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified property from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function propertiesDestroy(Property $property)
    {
        try {
            $this->propertyService->deleteProperty($property);

            Log::info('Property deleted successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete property', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to delete property. ' . $e->getMessage());
        }
    }


    public function dashboard()
{
    $totalUsers = User::count();
    $recentActivities = Activity::with('user')->latest()->take(10)->get();

    return view('admin.dashboard', compact('totalUsers', 'recentActivities'));
}

    // Add other admin methods as needed...
}
