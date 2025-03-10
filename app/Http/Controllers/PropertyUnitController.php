<?php

namespace App\Http\Controllers;

use App\Models\PropertyUnit;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyUnitController extends Controller
{
    /**
     * Display a listing of all property units.
     */
    public function index()
    {
        $units = PropertyUnit::all();
        if ($units->isEmpty()) {
            return response()->json(['message' => 'No property units found.'], 404);
        }

        return response()->json($units);
    }
    /**
     * Store a newly created property unit in storage.
     */
    public function store(Request $request)
    {
            try {
                $validated = $request->validate([
                    'property_id' => 'required|integer',
                    'unit_category' => 'required|string',
                    'unit_name' => 'required|string',
                    'unit_type' => 'required|string',
                    'unit_no' => 'required|string',
                    'description' => 'nullable|string',
                    'person_allowed' => 'required|integer',
                    'additionalbed' => 'required|boolean',
                    'mainimg' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                    'isactive' => 'required|boolean',
                ]);
        
            } catch (\Illuminate\Validation\ValidationException $e) {
                
                dd($e->errors());  // This will display the validation error messages
            }
     
        // Handle the image upload if a file is provided
        $imagePath = null;
        if ($request->hasFile('mainimg')) {
            $imagePath = $request->file('mainimg')->store('property_images', 'public');
        }
    
        // Create the property unit
      $data=  propertyUnit::create([
            'property_id' => $validated['property_id'],  
            'unit_category' => $validated['unit_category'],
            'unit_name' => $validated['unit_name'],
            'unit_type' => $validated['unit_type'],
            'description' => $validated['description'],
            'unit_no' => $validated['unit_no'],
            'person_allowed' => $validated['person_allowed'],
            'additionalbed' => $validated['additionalbed'],
            'mainimg' => $imagePath,
            'isactive' => $validated['isactive'],
        ]);
       
        // Redirect or return response
        return redirect()->route('property-units.show', ['property_unit' => $data->property_id])
        ->with('success', 'Property unit created successfully');

    }
    
    /**
     * Display the specified property unit.
     */
 
public function show($property_id)
{
    
    $property = Property::with('property_uinit')->findOrFail($property_id);
    return view('property_units.show', compact('property_id', 'property'));
}
    /**
     * Display property units by property_id.
     */
    public function showByPropertyId($property_id)
    {
        $units = PropertyUnit::where('property_id', $property_id)->get();
        if ($units->isEmpty()) {
            return response()->json(['message' => 'No units found for this property.'], 404);
        }

        return response()->json($units);
    }

    /**
     * Update the specified property unit in storage.
     */
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'property_id' => 'nullable|integer|exists:properties,id',
        'unit_category' => 'nullable|in:room,seat',
        'unit_no' => 'nullable|string|max:50',
        'unit_name' => 'nullable|string|max:100',
        'unit_type' => 'nullable|string|max:50',
        'person_allowed' => 'nullable|integer|min:1',
        'additionalbed' => 'nullable|boolean',
        'mainimg' => 'nullable|string',
        'isactive' => 'nullable|boolean',
    ]);

    // Find the unit and update with the validated data
    $unit = PropertyUnit::findOrFail($id);
    $unit->update($validated);

    return redirect()->back()->with('success', 'Property unit updated successfully.');
}
    /**
     * Remove the specified property unit from storage.
     */
    public function destroy($id)
    {
        // Find the unit and delete it
        $unit = PropertyUnit::findOrFail($id);
        $unit->delete();

         return redirect()->back()->with('success', 'Property unit updated successfully.');
    }
}
