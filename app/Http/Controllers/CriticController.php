<?php

namespace App\Http\Controllers;

use App\Models\Critic;
use App\Http\Resources\CriticResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CriticController extends Controller
{
    public function index()
    {
        return CriticResource::collection(Critic::paginate(20));
    }

    public function show(Critic $critic)
    {
        return new CriticResource($critic);
    }

     /**
     * @OA\Delete(
     *     path="/api/critics/{id}",
     *     summary="Delete a critic review",
     *     tags={"Critics"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Critic ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Critic deleted"),
     *     @OA\Response(response=404, description="Critic not found")
     * )
     */

    public function destroy($id)
    {
        $critic = Critic::findOrFail($id);
        $critic->delete();
        return response()->json(['message' => 'Critic deleted'], 204);
    }
}

