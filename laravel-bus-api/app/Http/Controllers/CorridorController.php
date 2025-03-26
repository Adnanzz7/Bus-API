<?php

namespace App\Http\Controllers;

use App\Models\Corridor;
use App\Models\Bus;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CorridorController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [new Middleware('auth:sanctum')];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $corridor = Corridor::with(['bus', 'driver'])->get();
        return response()->json($corridor, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $buatcorridor = $request->validate([
            'corridor_code' => 'required|string|unique:corridors',
            'driver_id' => 'required|string|exists:drivers,driver_id',
            'bus_id' => 'required|integer|exists:buses,id',
            'duty_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i',
        ]);

        $conflict = Corridor::where('duty_date', $buatcorridor['duty_date'])
            ->where(function ($query) use ($buatcorridor) {
                $query->where('driver_id', $buatcorridor['driver_id'])
                      ->orWhere('bus_id', operator: $buatcorridor['bus_id']);
            })->exists();
        
        if ($conflict) {
            return response()->json(['message' => 'conflicting corridor or bus or driver is not available'], 401);
        }

        $start = strtotime($buatcorridor['start_time']);
        $finish = strtotime($buatcorridor['finish_time']);
        $buatcorridor['duty_time_in_minutes'] = ($finish - $start) / 60;

        $corridor = Corridor::create($buatcorridor);

        return response()->json($corridor, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $corridor = Corridor::with(['bus', 'driver'])->find($id);
        if (!$corridor) {
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json(["corridor" => $corridor], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $corridor = Corridor::find($id);
        if (!$corridor) {
            return response()->json(['message' => 'not found'], 404);
        }

        $corridor->delete();
        return response()->json(['message' => 'delete corridor success'], 200);
    }
}
