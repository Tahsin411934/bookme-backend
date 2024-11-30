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
public function apiForPropertyfacilities($property_id)
{
    $property_summary = Property::with('facilities.icons')  
                                ->where('property_id', $property_id)  
                                ->get(); 
   
    return response()->json($property_summary);  
}


}
