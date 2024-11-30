<?php

namespace App\Http\Controllers;
use App\Models\Icon;
use App\Models\PropertySummary;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertySummaryController extends Controller
{
    public function index()
    {
        $summaries = PropertySummary::all(); // Fetch all data
        return view('property_summary.index', compact('summaries'));
    }

    public function store(Request $request)
{
    
    // Validate the incoming request data
    $data = $request->validate([
        'value' => 'required|array',
        'property_id' => 'required|numeric',  // Allow nullable property_id
        'value' => 'required|array',
        'value.*' => 'required|string',
        'icon' => 'nullable|array',
        'icon.*' => 'nullable|string',
        'display' => 'required|array',
        'display.*' => 'required|in:yes,no',
    ]);
   
    // Store multiple summaries for the property
    foreach ($data['value'] as $key => $value) {
        $summary = new PropertySummary();
        $summary->property_id = $data['property_id'];  // this can now be nullable
        $summary->value = $value;
        $summary->display = $data['display'][$key];
        $summary->icon = $data['icon'][$key];

        // if (isset($data['image'][$key])) {
        //     $imagePath = $data['image'][$key]->store('property-summaries', 'public');
        //     $summary->image = $imagePath;
        // }

        $summary->save();
    }
    //  dd($summary->property_id);
    // Redirect after successful storage
    return redirect()->route('property-summary.show', ['property_summary' => $summary->property_id])
    ->with('success', 'Summaries added successfully.');
}

    
    

public function show($property_id)
{
    // Fetch the property and its summaries by property_id
    $property = Property::findOrFail($property_id);  // Will throw an error if property is not found
    $summaries = PropertySummary::where('property_id', $property_id)->get();  // Fetch all summaries related to the property
    $icons = Icon::all();
    // Return the view with the property, its summaries, and the property_id
    return view('property-summary.show', compact('property', 'summaries', 'property_id', 'icons'));
}



public function update(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'property_name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'city_district' => 'nullable|string|max:255',
    ]);

    // Find the summary by its ID
    $summary = PropertySummary::find($id);

    if ($summary) {
        // Update the summary with the new data
        $summary->value = $request->input('property_name');
        $summary->icon = $request->input('description');
        $summary->display = $request->input('city_district');

        // Save the updated summary
        $summary->save();

        // Redirect back with a success message
        return redirect()->back();
    }

    // If the summary doesn't exist, redirect with an error message
    return redirect()->route('property-summary.index')->with('error', 'Summary not found.');
}


public function destroy($id)
{
    
    $summary = PropertySummary::find($id);

   
    if ($summary) {
        
        $summary->delete();

       
        return redirect()->back();
    }

    
    return redirect()->route('property-summary.index')->with('error', 'Summary not found.');
}

}

