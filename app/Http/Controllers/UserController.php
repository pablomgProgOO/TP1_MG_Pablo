<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Critic;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate(20));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }
    /**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"login", "password", "email", "first_name", "last_name"},
 *             @OA\Property(property="login", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string")
 *         )
 *     ),
 *     @OA\Response(response=201, description="User created successfully")
 * )
 */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:50|unique:users',
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $requestData = $request->all();
        $requestData['password'] = bcrypt($request->password);

        $user = User::create($requestData);
        return response()->json($user, 201);
    }
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update an existing user",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, description="User ID", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", description="Updated email"),
     *             @OA\Property(property="first_name", type="string", description="Updated first name"),
     *             @OA\Property(property="last_name", type="string", description="Updated last name")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:50|unique:users,login,' . $id,
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:50|unique:users,email,' . $id,
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $requestData = $request->all();
        if (isset($requestData['password'])) {
            $requestData['password'] = bcrypt($request->password);
        }

        $user->update($requestData);
        return response()->json($user);
    }
    /**
 * @OA\Get(
 *     path="/api/users/{id}/preferred-language",
 *     summary="Get a user's preferred language",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="User's preferred language"),
 *     @OA\Response(response=404, description="User not found")
 * )
 */
    public function preferredLanguage($id)
    {
        $user = User::findOrFail($id);

        $preferredLanguage = Critic::where('user_id', $id)
        ->join('films', 'critics.film_id', '=', 'films.id')
        ->selectRaw('films.language_id, COUNT(*) as count')
        ->groupBy('films.language_id')
        ->orderByDesc('count')
        ->first();
        if (!$preferredLanguage) {
            return response()->json(['message' => 'No preferred language found'], 404);
        }

        return response()->json(['preferred_language' => $preferredLanguage->language_id]);
    }
}

