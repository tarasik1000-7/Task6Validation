<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
        return view('owners.index', compact('owners'));
    }

    public function show(Owner $owner)
    {
        $owner->load('cars.owner');
        return view('owners.show', compact('owner'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
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
            ],
            [
                'name.required' => 'Owner name is required.',
                'name.string' => 'Owner name must be a string.',
                'name.min' => 'Owner name must be at least 2 characters.',
                'name.max' => 'Owner name must not exceed 50 characters.',
                'name.regex' => 'Owner name contains invalid characters.',

                'surname.required' => 'Owner surname is required.',
                'surname.string' => 'Owner surname must be a string.',
                'surname.min' => 'Owner surname must be at least 2 characters.',
                'surname.max' => 'Owner surname must not exceed 50 characters.',
                'surname.regex' => 'Owner surname contains invalid characters.',
            ]
        );

        Owner::create($data);

        return redirect()->route('owners.index')
            ->with('success', 'Owner created successfully.');
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $data = $request->validate(
            [
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
            ],
            [
                'name.required' => 'Owner name is required.',
                'name.string' => 'Owner name must be a string.',
                'name.min' => 'Owner name must be at least 2 characters.',
                'name.max' => 'Owner name must not exceed 50 characters.',
                'name.regex' => 'Owner name contains invalid characters.',

                'surname.required' => 'Owner surname is required.',
                'surname.string' => 'Owner surname must be a string.',
                'surname.min' => 'Owner surname must be at least 2 characters.',
                'surname.max' => 'Owner surname must not exceed 50 characters.',
                'surname.regex' => 'Owner surname contains invalid characters.',
            ]
        );

        $owner->update($data);

        return redirect()->route('owners.index')
            ->with('success', 'Owner updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted successfully.');
    }
}