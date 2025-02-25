<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;

class SpotController extends Controller
{
    // Show all spots
    public function index()
    {
        $spots = Spot::all();
       
        return view('spots.index', compact('spots'));
    }

    // Store a new spot
    public function store(Request $request)
    {
        Spot::create($request->all());
        return redirect()->route('spots.index')->with('success', 'Spot added successfully!');
    }

    // Show the form to edit a specific spot
    public function edit(Spot $spot)
    {
        return view('spots.edit', compact('spot'));
    }

    // Update an existing spot
    public function update(Request $request, Spot $spot)
    { 
        // Validate the request data if needed
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        // Update the spot with the validated data
        $spot->update($validated);

        // Redirect back to the index page with success message
        return redirect()->route('spots.index')->with('success', 'Spot updated successfully!');
    }

    // Delete a spot
    public function destroy(Spot $spot)
    {
        $spot->delete();
        return redirect()->route('spots.index')->with('success', 'Spot deleted successfully!');
    }
}
