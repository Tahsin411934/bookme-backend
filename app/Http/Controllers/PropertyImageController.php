<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'property_id' => 'required|max:255|integer',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure it's an image file
            'caption' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('path')) {
            // Store the image in the 'public/images/' directory
            // The 'public' disk is linked to 'storage/app/public'
            $imagePath = $request->file('path')->store('images', 'public');
        }

        // Store the image data in the database
        PropertyImage::create([
            'property_id' => $request->property_id,
            'path' => $imagePath,  // Store the file path in the database
            'caption' => $request->caption,
        ]);

        // Redirect or return response
        return redirect()->back();
        // return redirect()->route('property_images.show',[$request->property_id])->with('success', 'Property image added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($propertyId)
    { 
        $property = Property::where('property_id', $propertyId)->firstOrFail();

        // Fetch the property images for the given property ID
        $propertyImages = PropertyImage::where('property_id', $propertyId)->get();
    
        // Pass the propertyImages to the view
        return view('property_images.show', compact('propertyImages', 'propertyId', 'property'));
    }
    




   
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($image_id)
    {
        // Find the image by ID
        $propertyImage = PropertyImage::findOrFail($image_id);

        // Delete the image file from storage (if exists)
        if ($propertyImage->path && file_exists(storage_path('app/public/' . $propertyImage->path))) {
            unlink(storage_path('app/public/' . $propertyImage->path));  // Delete the image file
        }

        // Delete the property image from the database
        $propertyImage->delete();

        // Redirect with a success message
        return redirect()->route('property_images.show',[$propertyImage->property_id])->with('success', 'Property image deleted successfully.');
    }
}
