<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * @group Events
     * List events
     * @queryParam type string Type (indoor/outdoor/road/xc/trail).
     * @queryParam date_from date yyyy-mm-dd.
     * @queryParam date_to date yyyy-mm-dd.
     * @queryParam q string Søk (navn/by/stadion).
     * @unauthenticated
     */
    public function index()
{
    /**
    * @group Events
    * Create event
    * @bodyParam name string required Navn. Example: Sommerstevnet Kristiansand
    * @bodyParam type string required indoor/outdoor/road/xc/trail. Example: outdoor
    * @bodyParam start_date date required yyyy-mm-dd. Example: 2025-09-13
    * @bodyParam end_date date Sluttdato.
    * @bodyParam city string By. Example: Kristiansand
    * @bodyParam venue string Stadion. Example: Kristiansand stadion
    * @unauthenticated
    */
    return Event::query()
        ->when(request('type'), fn($q, $t) => $q->where('type', $t))
        ->when(request('date_from'), fn($q, $d) => $q->whereDate('start_date', '>=', $d))
        ->when(request('date_to'), fn($q, $d) => $q->whereDate('start_date', '<=', $d))
        ->when(request('q'), function ($q, $term) {
            $q->where(function ($qq) use ($term) {
                $qq->where('name', 'ilike', "%$term%")
                   ->orWhere('city', 'ilike', "%$term%")
                   ->orWhere('venue', 'ilike', "%$term%");
            });
        })
        ->orderByDesc('start_date')
        ->paginate(request('per_page', 50));
}

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());
        return response()->json($event, 201);
    }
}
