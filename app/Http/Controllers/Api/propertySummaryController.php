<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;

class propertySummaryController extends Controller
// property api for home
{
   public function apiCreate(){

    $property_summary = Property::with('propertySummaries.icons','property_uinit.price')->get();
    return response()->json($property_summary);
}
// property images api for home
public function apiForPropertyImages($property_id){

    $Images = PropertyImage::where('property_id', $property_id)->get();

    return response()->json($Images);
}
// property with id api for home
public function apiForPropertySummary($property_id)
{
    $property_summary = Property::with('propertySummaries.icons')  
                                ->where('property_id', $property_id)  
                                ->get();  
   
    return response()->json($property_summary);  
}
// property facilities api for home
public function apiForPropertyFacilities($property_id)
{
    $property_summary = Property::with([
        'facilities.icons',
        'facilities.facilityTypes'
    ])->where('property_id', $property_id)->first();

    if (!$property_summary) {
        return response()->json(['message' => 'Property not found'], 404);
    }

    // Transform and group facilities by their facility_typename
    $groupedFacilities = $property_summary->facilities->groupBy(function ($facility) {
        return $facility->facilityTypes->facility_typename ?? 'Unknown';
    })->map(function ($group, $key) {
        return [
            'facility_type' => $key,
            'facilities' => $group->map(function ($facility) {
                return [
                    'facility_name' => $facility->facilty_name,
                    'value' => $facility->value,
                    'img' => $facility->img,
                    'icon' => $facility->icons->icon_name ?? null,
                ];
            })->values() // Ensure facilities is an array
        ];
    })->values(); // Ensure grouped facilities is an array

    // Prepare final response structure
    $response = [
        'property_id' => $property_summary->property_id,
        'property_name' => $property_summary->property_name,
        'description' => $property_summary->description,
        'facilities' => $groupedFacilities->toArray(), // Convert to plain array
    ];

    return response()->json($response);
}




}
