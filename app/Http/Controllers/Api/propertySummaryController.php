<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;

class propertySummaryController extends Controller
{
   public function apiCreate(){
    $property_summary = Property::with('propertySummaries.icons','property_uinit.price')->get();

    // Return the data as a JSON response
    return response()->json($property_summary);
}


public function apiForPropertyImages($property_id){
    $Images = PropertyImage::where('property_id', $property_id)->get();
    return response()->json($Images);
}

public function apiForPropertySummary($property_id)
{
    $property_summary = Property::with('propertySummaries.icons')  // eager load 'propertySummaries' relationship
                                ->where('property_id', $property_id)  // filter by property_id
                                ->get();  // fetch the data
   
    return response()->json($property_summary);  // return as JSON response
}

public function apiForPropertyfacilities($property_id)
{
    $property_summary = Property::with('facilities.icons')  // eager load 'propertySummaries' relationship
                                ->where('property_id', $property_id)  // filter by property_id
                                ->get();  // fetch the data
   
    return response()->json($property_summary);  // return as JSON response
}


}
