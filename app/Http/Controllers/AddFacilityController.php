<?php

namespace App\Http\Controllers;

use App\Models\PropertyFacility;
use App\Models\Property;
use App\Models\Icon;
use App\Models\PropertyFacilityType;
use Illuminate\Http\Request;

class AddFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $facilities = PropertyFacility::all();
        return view('property_facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('property_facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    { 
        
      $data =  $request->validate([
            'property_id' => 'required|integer',
            'facility_type' => 'required|string|max:255',
            'facility_name' => 'required|string|max:255',
            'value' => 'required|string',
            'icon' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'isactive' => 'required|boolean',
            'serialno' => 'nullable|string|max:255',
        ]);

        // Store the image if it exists
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('facility_images', 'public');
        } else {
            $imagePath = null;
        }

        // Create the new property facility record
       $inserteData = PropertyFacility::create([
            'property_id' => $request->property_id,
            'facility_type' => $request->facility_type,
            'facilty_name' => $request->facility_name,
            'value' => $request->value,
            'icon' => $request->icon,
            'img' => $imagePath,
            'isactive' => $request->isactive,
            'serialno' => $request->serialno,
        ]);
     
        return redirect('/facilities/' . $inserteData->property_id)
        ->with('success', 'Facility updated successfully.');
       
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    
    $property = Property::with('facilities')->findOrFail($id);
    $facilitiestype = PropertyFacilityType::where('property_category', $property->category_id)->get();
    $icons = Icon::all();
    return view('facilities.show', compact('property', 'id', 'facilitiestype', 'icons'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facility = PropertyFacility::findOrFail($id);
        return view('property_facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
        $data = $request->validate([
            'facility_type' => 'string|max:255',
            'facility_name' => 'string|max:255',
            'value' => 'required|string',
        ]);

        $facility = PropertyFacility::where('facility_type', $id)->firstOrFail();
        $facility->update([  
            'facilty_name' => $data['facility_name'], 
            'value' => $data['value'],             
        ]);
       
        return redirect('/facilities/' . $facility->property_id)
    ->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facility = PropertyFacility::findOrFail($id);
        if ($facility->img && file_exists(storage_path('app/public/' . $facility->img))) {
            unlink(storage_path('app/public/' . $facility->img));
        }

        $facility->delete();
        return redirect()->route('property_facilities.index')
                         ->with('success', 'Facility deleted successfully.');
    }
}