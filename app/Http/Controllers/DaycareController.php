<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DaycareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('dagopvang/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('dagopvang/Planning');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedDog = $request->validate([
            'name' => 'required|string|max:255',
            'race' => 'required|string|max:255',
            'age' => 'required|numeric|gt:0',
            'been_to_daycare' => 'boolean',
        ]);
        $validatedDaycare = $request->validate([
            'date' => 'required|date',
        ]);
        $validatedDaycare['date'] = Carbon::parse($validatedDaycare['date']);

        $request
            ->user()
            ->dogs()
            ->firstOrCreate($validatedDog)
            ->daycares()
            ->firstOrCreate($validatedDaycare);

        return redirect()->route('dagopvang.planning');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
