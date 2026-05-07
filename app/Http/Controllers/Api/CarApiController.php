<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarApiController extends Controller
{
    public function index()
    {
        return response()->json(Car::with(['owner', 'photos'])->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reg_number' => [
                'required',
                'string',
                'min:5',
                'max:10',
                'regex:/^[A-ZА-ЯІЇЄ0-9-]+$/u',
                'unique:cars,reg_number',
            ],
            'brand' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9\s\-]+$/u',
            ],
            'model' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9\s\-]+$/u',
            ],
            'owner_id' => [
                'required',
                'exists:owners,id',
            ],
        ]);

        $car = Car::create($data);

        return response()->json([
            'message' => 'Car created successfully.',
            'data' => $car->load(['owner', 'photos']),
        ], 201);
    }

    public function show(Car $car)
    {
        return response()->json($car->load(['owner', 'photos']));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'reg_number' => [
                'required',
                'string',
                'min:5',
                'max:10',
                'regex:/^[A-ZА-ЯІЇЄ0-9-]+$/u',
                Rule::unique('cars', 'reg_number')->ignore($car->id),
            ],
            'brand' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9\s\-]+$/u',
            ],
            'model' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'regex:/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9\s\-]+$/u',
            ],
            'owner_id' => [
                'required',
                'exists:owners,id',
            ],
        ]);

        $car->update($data);

        return response()->json([
            'message' => 'Car updated successfully.',
            'data' => $car->load(['owner', 'photos']),
        ]);
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully.',
        ]);
    }
}