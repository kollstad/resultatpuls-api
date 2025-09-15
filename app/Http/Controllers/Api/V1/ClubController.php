<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClubRequest;
use App\Models\Club;

class ClubController extends Controller
{
    /**
     * @group Clubs
     * List clubs
     * @queryParam district_id uuid Filter på krets.
     * @queryParam q string Fritekstsøk på navn.
     * @unauthenticated
     */
    public function index()
{
    /**
     * @group Clubs
     * Create club
     * @bodyParam name string required Navn. Example: Kristiansand IF Friidrett
     * @bodyParam short_name string Forkortelse. Example: KIF
     * @bodyParam district_id uuid required Krets-ID (uuid).
     * @unauthenticated
     */
    return Club::query()
        ->with('district')
        ->when(request('district_id'), fn($q, $id) => $q->where('district_id', $id))
        ->when(request('q'), fn($q, $term) => $q->where('name', 'ilike', "%$term%"))
        ->orderBy('name')
        ->paginate(request('per_page', 50));
}

    public function store(StoreClubRequest $request)
    {
        $club = Club::create($request->validated());
        return response()->json($club, 201);
    }
}
