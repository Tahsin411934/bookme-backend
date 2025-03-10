<?php
namespace App\Http\Controllers;

use App\Models\TourConsultationRequest;
use Illuminate\Http\Request;

class TourConsultationRequestController extends Controller
{
    // Display all consultation requests
    public function index()
    {
        return response()->json(TourConsultationRequest::all());
    }

    // Store a new consultation request
    public function store(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'address' => 'required|string',
            'additional_info' => 'nullable|string',
            'property_name' => 'nullable|string',
        ]);

        $consultation = TourConsultationRequest::create($request->all());

        return response()->json(['message' => 'Consultation request submitted successfully!', 'data' => $consultation], 201);
    }

    // Show a single consultation request
    public function show($id)
    {
        return response()->json(TourConsultationRequest::findOrFail($id));
    }

    // Update an existing consultation request
    public function update(Request $request, $id)
    { 
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'number' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'additional_info' => 'nullable|string',
            'property_name' => 'nullable|string',
        ]);

        $consultation = TourConsultationRequest::findOrFail($id);
        $consultation->update($request->all());

        return response()->json(['message' => 'Consultation request updated successfully!', 'data' => $consultation]);
    }

    // Delete a consultation request
    public function destroy($id)
    {
        TourConsultationRequest::findOrFail($id)->delete();
        return response()->json(['message' => 'Consultation request deleted successfully!']);
    }
}
