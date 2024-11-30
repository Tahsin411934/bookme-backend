<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   



    try {
      
        $validated = $request->validate([
           'unit_id' => 'required|exists:property_unit,unit_id',
            'price' => 'required|numeric',
            'effectfrom' => 'required|date',
            'effective_till' => 'nullable|date',
        ]);

       

    } catch (\Illuminate\Validation\ValidationException $e) {
        
        dd($e->errors()); // This will show the validation error messages
    }


        // Validate the request
    //   $data =  $request->validate([
    //         'unit_id' => 'required|exists:property_unit,unit_id',
    //         'price' => 'required|numeric',
    //         'effectfrom' => 'required|date',
    //         'effective_till' => 'nullable|date|after:effectfrom',
    //     ]);
    //     dd($data);
        // Create a new price record
        $price = Price::create($request->all());

        return redirect()->back();
    }
}
