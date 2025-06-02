<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class DaycareController extends Controller
{
    /**
     * @author Damien-Code
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('dagopvang/Index');
    }

    /**
     * @author Damien-Code
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('dagopvang/Planning');
    }

    /**
     * @author Damien-Code
     * Store the validated subscription for daycare.
     * This method first validates the dog values and then validates the datevalue.
     * If a dog already has been registered, it uses the already stored data, else it creates a new dog
     * The same happens to the date. If the new date is already in the database, it uses the already stored date, else it creates a new date.
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
            'date' => 'required|date|after_or_equal:today',
        ]);
        $validatedDaycare['date'] = Carbon::parse($validatedDaycare['date']);

        $request
            ->user()
            ->dogs()
            ->firstOrCreate($validatedDog)
            ->daycares()
            ->firstOrCreate($validatedDaycare);

//        Mail::raw('Het dagopvangschema is aangevraagd op', function ($message) use ($validatedDog, $validatedDaycare, $request) {
//            $message->to($request->user()->email);
//            $message->subject('Dagopvangschema aangevraagd');
//            $message->text('Uw aanvraag voor ' . $validatedDog['name'] . ' op ' . $validatedDaycare['date']->format('Y-m-d') . ' is goed ontvangen. We zullen zo spoedig mogelijk contact met u opnemen.');
//
//        });
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
