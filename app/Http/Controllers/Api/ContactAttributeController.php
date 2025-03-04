<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactAttributeController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $contactAttributes = ContactAttribute::all();
        return response()->json($contactAttributes);
    }
   
   
}
