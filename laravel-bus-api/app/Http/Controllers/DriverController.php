<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DriverController extends Controller implements HasMiddleware
{
    public static function Middleware()
    {
        return [new Middleware('auth:sanctum')];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Driver::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bikindriver = $request->validate([
            'driver_id' => 'required|string|unique:drivers',
            'name' => 'required|string',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string|size:12',
            'address' => 'required|string',
            'email' => 'required|email'
        ]);
        Driver::create($bikindriver);
        
        return response()->json(['message' => 'create driver success'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $driver_id)
    {
        $driver = Driver::where('driver_id', $driver_id)->first();
        if (!$driver) 
        {
            return response()->json(['message' => 'not found'],404);
        }
        
        return response()->json(['driver' => $driver], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $driver_id)
    {
        $driver = Driver::where('driver_id', $driver_id)->first();
        if (!$driver) 
        {
            return response()->json(['message' => 'not found'],404);
        }
        $bikindriver = $request->validate([
            'driver_id' => 'required|string|unique:drivers',
            'name' => 'required|string',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string|size:12',
            'address' => 'required|string',
            'email' => 'required|email'
        ]);
        $driver->update($bikindriver);
        
        return response()->json(['message' => 'update driver success'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $driver_id)
    {
        $driver = Driver::where('driver_id', $driver_id)->first();
        if (!$driver) 
        {
            return response()->json(['message' => 'not found'],404);
        }

        $driver->delete();
        return response()->json(['message' => 'delete driver success']);
    }
}
