<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Film;
use App\Http\Resources\ActorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    public function index()
    {
        return ActorResource::collection(Actor::paginate(20));
    }

    public function show(Actor $actor)
    {
        return new ActorResource($actor);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'birthdate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actor = Actor::create($request->all());
        return new ActorResource($actor);
    }
        /**
     * @OA\Get(
     *     path="/api/films/{id}/actors",
     *     summary="Get all actors for a specific film",
     *     tags={"Actors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Film ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of actors in the film"),
     *     @OA\Response(response=404, description="Film not found")
     * )
     */

    public function getActorsByFilm($id)
    {
        $film = Film::findOrFail($id);
        return response()->json(['film_id' => $id, 'actors' => $film->actors]);
    }
    
}

