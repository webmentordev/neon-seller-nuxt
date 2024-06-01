<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $contacts = Contact::latest()->get();
        return ContactResource::collection($contacts);
    }
    public function store(Request $request){
        $contact = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email'],
            'subject' => ['required', 'max:255'],
            'message' => ['required']
        ]);
        Contact::create($contact);
        return response()->json([
            'message' => 'Message has been sent!',
        ], 201);
    }
}