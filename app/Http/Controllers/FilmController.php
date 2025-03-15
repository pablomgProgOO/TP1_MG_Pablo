<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Critic;
use App\Models\Language;
use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
/**
 * @OA\Schema(
 *     schema="Film",
 *     title="Film",
 *     description="Film model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="ACADEMY DINOSAUR"),
 *     @OA\Property(property="description", type="string", example="A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies"),
 *     @OA\Property(property="release_year", type="integer", example=2006),
 *     @OA\Property(property="language_id", type="integer", example=1, description="Foreign key referring to Language"),
 *     @OA\Property(property="length", type="integer", example=86, description="Film length in minutes"),
 *     @OA\Property(property="rating", type="string", example="PG"),
 *     @OA\Property(property="special_features", type="string", example="Deleted Scenes,Behind the Scenes"),
 *     @OA\Property(property="image", type="string", example=""),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2006-02-15 15:03:42"),
 * )
 */

class FilmController extends Controller
{
  /**
 * @OA\Get(
 *     path="/api/films",
 *     summary="Get all films",
 *     tags={"Films"},
 *     @OA\Response(
 *         response=200,
 *         description="List of films",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Film")
 *         )
 *     )
 * )
 */
    public function index()
    {
        return FilmResource::collection(Film::paginate(20));
    }
//Search ne fonctionne pas
    public function search(Request $request)
    {

        $query = Film::query();

        if ($request->filled('keyword')) { 
            $query->where('title', 'LIKE', '%' . $request->keyword . '%')->get;
        }
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        if ($request->filled('minLength') && is_numeric($request->minLength)) {
            $query->where('length', '>=', (int)$request->minLength);
        }
        if ($request->filled('maxLength') && is_numeric($request->maxLength)) {
            $query->where('length', '<=', (int)$request->maxLength);
        }

        $films = $query->paginate(20)->get();

        return FilmResource::collection($films);
    }
    
    public function show(Film $film)
    {
        return new FilmResource($film);
    }
    /**
 * @OA\Get(
 *     path="/api/films/{id}/critics",
 *     summary="Get a film along with its critics",
 *     tags={"Films"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Film ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Film details with critics")
 * )
 */
    public function showWithCritics($id)
    {
        $film = Film::with('critics')->find($id);

        if (!$film) {
            return response()->json(['message' => 'Film not found'], 404);
        }

        return new FilmResource($film);
    }      
/**
 * @OA\Get(
 *     path="/api/films/{id}/average-score",
 *     summary="Get the average score for a film",
 *     tags={"Films"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Film ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Average film score")
 * )
 */
    public function getAverageScore($id)
    {
        $average = Critic::where('film_id', $id)->avg('rating');

        if (is_null($average)) {
            return response()->json(['message' => 'No reviews found for this film'], 404);
        }

        return response()->json(['film_id' => $id, 'average_score' => round($average, 2)]);
    }
}

