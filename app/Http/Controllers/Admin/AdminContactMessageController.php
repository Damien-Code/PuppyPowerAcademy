<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Training;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(
            'settings/admin/Contact',
            [
                'messages' => Contact::where(
                    'completed_at', '>', date('d.m.Y', strtotime("-1 week"))
                )
                ->orWhereNull('completed_at')
                ->orderBy('created_at', 'desc')->get(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validatedContact = $request->validate([
            'is_completed' => 'required|bool'
        ]);

        $contact->is_completed = $validatedContact['is_completed'];
        $contact->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
