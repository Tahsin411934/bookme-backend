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
    public function store(Request $request){
    
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

        $summary->save();
    }
   
    return redirect()->route('property-summary.show', ['property_summary' => $summary->property_id])
    ->with('success', 'Summaries added successfully.');
}

public function show($property_id)
{
    
    $property = Property::findOrFail($property_id);  
    $summaries = PropertySummary::where('property_id', $property_id)->get();  
    $icons = Icon::all();
   
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

        $summary->save();

        return redirect()->back();
    }

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

