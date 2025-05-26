<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dog;
use Inertia\Inertia;

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
