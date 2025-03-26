<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BusController extends Controller implements HasMiddleware
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
        return response()->json(Bus::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bikinbus = $request->validate([
            'plate_number' => 'required|string',
            'brand' => 'required|string',
            'type' => 'required|in:small,big,articulated',
            'fuel' => 'required|in:petrol,gas,diesel,electric'
        ]);
        Bus::create($bikinbus);
        
        return response()->json(['message' => 'create bus success'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bus = Bus::find($id);
        if (!$bus) {
            return response()->json(['massage' => 'gagal'],404);
        }

        return response()->json($bus,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bus = Bus::find($id);
        if (!$bus) {
            return response()->json(['massage' => 'not found'],404);
        }
        
        $bikinbus = $request->validate([
            'plate_number' => 'required|string',
            'brand' => 'required|string',
            'type' => 'required|in:small,big,articulated',
            'fuel' => 'required|in:petrol,gas,diesel,electric'
        ]);
        $bus->update($bikinbus);
        
        return response()->json(['message' => 'update bus success'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bus = Bus::find($id);
        if (!$bus) {
            return response()->json(['massage' => 'not found'],404);
        }
        $bus->delete();
        return response()->json(['message' => 'delete bus success'],200);
    }
}
