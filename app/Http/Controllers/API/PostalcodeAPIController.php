<?php

namespace App\Http\Controllers\API;

use App\Postalcode;
use App\Http\Resources\PostalcodeCollection;
use App\Http\Resources\PostalcodeResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostalcodeAPIController extends Controller
{
    public function index()
    {
        return new PostalcodeCollection(Postalcode::paginate());
    }
 
    public function show(Postalcode $postalcode)
    {
        return new PostalcodeResource($postalcode->load([]));
    }

    public function store(Request $request)
    {
        return new PostalcodeResource(Postalcode::create($request->all()));
    }

    public function update(Request $request, Postalcode $postalcode)
    {
        $postalcode->update($request->all());

        return new PostalcodeResource($postalcode);
    }

    public function destroy(Request $request, Postalcode $postalcode)
    {
        $postalcode->delete();

        return response()->noContent();
    }
}
