<?php

namespace App\Http\Controllers\API;

use App\Connection;
use App\Http\Resources\ConnectionCollection;
use App\Http\Resources\ConnectionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConnectionAPIController extends Controller
{
    public function index()
    {
        return new ConnectionCollection(Connection::paginate());
    }
 
    public function show(Connection $connection)
    {
        return new ConnectionResource($connection->load(['eois']));
    }

    public function store(Request $request)
    {
        return new ConnectionResource(Connection::create($request->all()));
    }

    public function update(Request $request, Connection $connection)
    {
        $connection->update($request->all());

        return new ConnectionResource($connection);
    }

    public function destroy(Request $request, Connection $connection)
    {
        $connection->delete();

        return response()->noContent();
    }
}
