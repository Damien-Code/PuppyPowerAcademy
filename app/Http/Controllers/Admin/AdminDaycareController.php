<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Daycare;
use App\Models\Daycare_Dog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Dog;
use Inertia\Inertia;

use function Laravel\Prompts\error;

class AdminDaycareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Dog::join("daycare_dogs",function($join){
            $join->on(['dogs.id' => 'daycare_dogs.dog_id']);
        })
        ->join("daycares", function($join){
            $join->on(['daycares.id' => 'daycare_dogs.daycare_id']);
        })
        ->join("users", function($join){
            $join->on(['users.id' => 'dogs.user_id']);
        })
        ->select("dogs.*", "date as daycare_date", "users.name as owner", "users.email")
            ->orderBy('daycare_date','asc')
            ->get();
            // dd($query);
            
        return Inertia::render(
            'settings/admin/Dagopvang',
            [
            'daycareRequests' => $query
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
        // dd($request);

        //if dates are the same, validate an impossible scenario for error
        if($request->date == $request->oldDate || Carbon::parse($request->date)->isPast()){$request->validate(['date'=> 'required|integer']);}

        $validatedDaycare = $request->validate([
            'date' => 'required|date',
        ]);
        $oldDaycareId = Daycare::where(['date' => $request->oldDate])->first()->id;
        //get new daycare if exists 
        function getDaycare($validatedDaycare){
            return Daycare::where(['date' => $validatedDaycare['date']])->first();
        }
        $daycare = getDaycare($validatedDaycare);
        if($daycare == null){
            //create new daycare
            $daycare = Daycare::create($validatedDaycare);
        }

        //link dog to new daycare date
        // dd($request->id, $oldDaycareId);
        $daycare_dog = Daycare_Dog::where(['dog_id'=>(int)$request->id,'daycare_id'=>$oldDaycareId])->first();
        // dd($daycare_dog);
        $daycare_dog->update(['daycare_id'=>$daycare->id]);
        
        
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
