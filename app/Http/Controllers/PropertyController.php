<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\ServiceCategory ;
use App\Models\Destination ;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all(); // Retrieve all properties
        $categories = ServiceCategory::all();
        $destinations = Destination::all();
        return view('properties.index', compact('properties', 'categories', 'destinations')); // Load view
    }


    public function create(){
        $properties = Property::all();
        return response()->json([
            'success'=>true,
            'message' => "this is my first api test inside controller",
            'data'=> $properties
        ]);
    }





    public function store(Request $request)
    {

        
        
        try {
          $data=  $request->validate([
                'category_id' => 'required|integer',
                'destination_id' => 'required|integer',
                'property_name' => 'required|string|max:255',
                'description' => 'required|string',
                'city_district' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'lat_long' => 'required|string|max:255', 
                'main_img' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'isactive' => 'required|boolean',
            ]);

           
        }  catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); 
        }
       

        // Store the uploaded image
        $filePath = $request->file('main_img')->store('properties', 'public');

        // Create a new property entry
        Property::create([
            'category_id' => $request->category_id,
            'destination_id' => $request->destination_id,
            'property_name' => $request->property_name,
            'description' => $request->description,
            'district_city' => $request->{'city_district'},
            'address' => $request->address,
            'lat_long' => $request->{'lat_long'},
            'main_img' => $filePath,
            'isactive' => $request->isactive,
        ]);
        session()->flash('success', 'Property added successfully!');
        // Redirect to properties index with success message
        return redirect()->route('properties.index');
    }

    public function update(Request $request, $id)
    {
        // Find the property by ID or fail if not found
        $property = Property::findOrFail($id);

        // Validate the incoming data
        try {
            // Perform validation with the required rules
            $validated = $request->validate([
                'destination_id' => 'nullable|integer',
                'property_name' => 'required|string|max:255',
                'description' => 'required|string',
                'city_district' => 'required|string|max:255', // Change this to match the input field name
                'address' => 'required|string|max:255',
                'lat_long' => 'required|string|max:255', // Change this to match the input field name
                'isactive' => 'nullable|boolean',
                'main_img' => 'required|string|max:255', // Validate the image if present
               
            ]);
         
            // Debugging: Show the validated data
          
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle the validation exception
            dd($e->errors()); // This will show the validation error messages
        }
       
        

        // Assign validated data to the property model
       
        // $property->destination_id = $validated['destination_id'];
        $property->property_name = $validated['property_name'];
        $property->description = $validated['description'];
        $property->district_city = $validated['city_district'];
        $property->address = $validated['address'];
        $property->lat_long = $validated['lat_long'];
        $property->main_img = $validated['main_img'];
        $property->isactive = $request->has('isactive') ? true : false;

        $property->save();

        
        return redirect()->route('properties.index')->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        // Delete the property and its associated image
        if ($property->main_img) {
            Storage::delete($property->main_img);
        }

        $property->delete();

        // Redirect to properties index with success message
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully!');
    }
}
