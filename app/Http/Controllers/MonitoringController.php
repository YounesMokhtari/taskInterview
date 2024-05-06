<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonitoringRequest;
use App\Http\Requests\UpdateMonitoringRequest;
use App\Http\Resources\MonitoringCollection;
use App\Http\Resources\MonitoringResource;
use App\Models\Monitor;
use App\Models\Monitoring;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return Response::json([
            'monitors' => new MonitoringCollection(Monitor::query()
                ->latest()
                ->paginate()),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonitoringRequest $request): JsonResponse
    {
        $validatedMonitoringData = $request->validated();
        $monitor = Monitor::query()
            ->create($validatedMonitoringData);
        return Response::json([
            'monitor' => new MonitoringResource($monitor)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Monitor $monitor): JsonResponse
    {
        $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'status_code' => 'sometimes|numeric'
        ]);
        $monitor->load([
            'histories' => fn ($q) => $q
                ->when(
                    $request->filled('start_date'),
                    fn ($q) => $q->where('start_date', '>', $request->datetime('start_date'))
                )
                ->when(
                    $request->filled('end_date'),
                    fn ($q) => $q->where('end_date', '<', $request->datetime('end_date'))
                )
                ->when(
                    $request->filled('status_code'),
                    fn ($q) => $q->where('status_code', $request->integer('status_code'))
                )
        ]);
        return Response::json([
            'monitoring' => new MonitoringResource($monitor)
        ]);
    }
}
