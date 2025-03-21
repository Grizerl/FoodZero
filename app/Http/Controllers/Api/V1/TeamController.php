<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Team\TeamStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamStoreRequest $teamStoreRequest)
    {
        $user = User::create($teamStoreRequest->all());
        
        return response()->json([
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        
        return response()->json([
            'message' => 'User delete'
        ], 204);
    }
}
