<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Models\CarPhoto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('owner')->latest()->paginate(10);
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $owners = Owner::orderBy('name')->get();
        return view('cars.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
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
                'photos.*' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'reg_number.required' => 'Registration number is required.',
                'reg_number.string' => 'Registration number must be a string.',
                'reg_number.min' => 'Registration number must be at least 5 characters.',
                'reg_number.max' => 'Registration number must not exceed 10 characters.',
                'reg_number.regex' => 'Registration number format is invalid.',
                'reg_number.unique' => 'This registration number already exists.',

                'brand.required' => 'Car brand is required.',
                'brand.string' => 'Car brand must be a string.',
                'brand.min' => 'Car brand must be at least 2 characters.',
                'brand.max' => 'Car brand must not exceed 50 characters.',
                'brand.regex' => 'Car brand contains invalid characters.',

                'model.required' => 'Car model is required.',
                'model.string' => 'Car model must be a string.',
                'model.min' => 'Car model must be at least 1 character.',
                'model.max' => 'Car model must not exceed 50 characters.',
                'model.regex' => 'Car model contains invalid characters.',

                'owner_id.required' => 'Owner is required.',
                'owner_id.exists' => 'Selected owner does not exist.',

                'photos.*.image' => 'Each uploaded file must be an image.',
                'photos.*.mimes' => 'Photos must be jpg, jpeg, png, or webp.',
                'photos.*.max' => 'Each photo must not be larger than 2MB.',
            ]
        );

        unset($data['photos']);

        $car = Car::create($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('car_photos', 'public');

                CarPhoto::create([
                    'car_id' => $car->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', 'Car created successfully.');
    }

    public function show(Car $car)
    {
        $car->load(['owner', 'photos']);
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $car->load(['owner', 'photos']);
        $owners = Owner::orderBy('name')->get();

        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate(
            [
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
                'photos.*' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'reg_number.required' => 'Registration number is required.',
                'reg_number.string' => 'Registration number must be a string.',
                'reg_number.min' => 'Registration number must be at least 5 characters.',
                'reg_number.max' => 'Registration number must not exceed 10 characters.',
                'reg_number.regex' => 'Registration number format is invalid.',
                'reg_number.unique' => 'This registration number already exists.',

                'brand.required' => 'Car brand is required.',
                'brand.string' => 'Car brand must be a string.',
                'brand.min' => 'Car brand must be at least 2 characters.',
                'brand.max' => 'Car brand must not exceed 50 characters.',
                'brand.regex' => 'Car brand contains invalid characters.',

                'model.required' => 'Car model is required.',
                'model.string' => 'Car model must be a string.',
                'model.min' => 'Car model must be at least 1 character.',
                'model.max' => 'Car model must not exceed 50 characters.',
                'model.regex' => 'Car model contains invalid characters.',

                'owner_id.required' => 'Owner is required.',
                'owner_id.exists' => 'Selected owner does not exist.',

                'photos.*.image' => 'Each uploaded file must be an image.',
                'photos.*.mimes' => 'Photos must be jpg, jpeg, png, or webp.',
                'photos.*.max' => 'Each photo must not be larger than 2MB.',
            ]
        );

        unset($data['photos']);

        $car->update($data);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('car_photos', 'public');

                CarPhoto::create([
                    'car_id' => $car->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        foreach ($car->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully.');
    }

    public function destroyPhoto(CarPhoto $photo)
    {
        Storage::disk('public')->delete($photo->path);

        $photo->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }
}