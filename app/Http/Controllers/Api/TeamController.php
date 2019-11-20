<?php

namespace App\Http\Controllers\Api;

use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\StoreValidation;
use App\Http\Resources\Team as TeamResource;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::paginate();

        return TeamResource::collection($teams);
    }

    public function store(StoreValidation $request)
    {
        $team = Team::create($request->validated());

        return response()->json(new TeamResource($team), Response::HTTP_CREATED);
    }

    public function show(Team $team)
    {
        return response()->json(new TeamResource($team), Response::HTTP_OK);
    }

    public function update(Team $team, Request $request)
    {
        $attributes = $request->only('full_name', 'email', 'phone_number', 'company', 'address', 'about');

        $team->update($attributes);

        return response()->json(new TeamResource($team), Response::HTTP_OK);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
