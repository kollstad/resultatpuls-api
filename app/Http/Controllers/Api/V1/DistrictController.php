<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDistrictRequest;
use App\Models\District;

class DistrictController extends Controller
{
    /**
     * @group Districts
     * List districts
     * @queryParam q string Søk på navn/kode. Example: Agder
     * @unauthenticated
     */
    public function index()
{
    /**
     * @group Districts
     * Create district
     * @bodyParam name string required Navn på krets. Example: Agder Friidrettskrets
     * @bodyParam code string required Kort kode. Example: AAK
     * @unauthenticated
     */
    $q = request('q');
    return District::query()
        ->when($q, fn($qq) => $qq->where('name', 'ilike', "%$q%")
                                 ->orWhere('code', 'ilike', "%$q%"))
        ->orderBy('name')
        ->paginate(request('per_page', 50));
}

    public function store(StoreDistrictRequest $request)
    {
        $district = District::create($request->validated());
        return response()->json($district, 201);
    }
}
