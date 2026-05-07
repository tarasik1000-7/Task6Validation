<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerApiController extends Controller
{
    public function index()
    {
        return response()->json(Owner::with('cars')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ\s\-]+$/u',
            ],
            'surname' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ\s\-]+$/u',
            ],
        ]);

        $owner = Owner::create($data);

        return response()->json([
            'message' => 'Owner created successfully.',
            'data' => $owner,
        ], 201);
    }

    public function show(Owner $owner)
    {
        return response()->json($owner->load('cars'));
    }

    public function update(Request $request, Owner $owner)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ\s\-]+$/u',
            ],
            'surname' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ\s\-]+$/u',
            ],
        ]);

        $owner->update($data);

        return response()->json([
            'message' => 'Owner updated successfully.',
            'data' => $owner,
        ]);
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return response()->json([
            'message' => 'Owner deleted successfully.',
        ]);
    }
}