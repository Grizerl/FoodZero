<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Team\TeamStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Api\Admin\Team\TeamStoreRequest $teamStoreRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(TeamStoreRequest $teamStoreRequest)
    {
        $user = User::create($teamStoreRequest->all());

        return response()->json([
            'user' => $user,
        ], 201);
    }

    /**
     * Summary of show
     * @param \App\Models\User $user
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param int  $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|max:255',
            'password' => 'string|min:6',
        ]);

        if (!$user) {
            return response()->json([
                'message' => 'User could not be found'
            ], 404);
        }

        $user->update($validate);

        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'User delete'
        ], 204);
    }
}
