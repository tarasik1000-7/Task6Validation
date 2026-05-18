<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OwnerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $owners = Owner::with(['cars', 'user'])->get();
        } else {
            $owners = Owner::with('cars')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('owners.index', compact('owners'));
    }

    public function show(Owner $owner)
{
    $this->authorize('view', $owner);

    $owner->load(['cars.photos', 'user']);

    return view('owners.show', compact('owner'));
}

    public function create()
    {
        $users = User::all();

        return view('owners.create', compact('users'));
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
                'user_id' => [
                    'nullable',
                    'exists:users,id',
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

                'user_id.exists' => 'Selected insurance agent does not exist.',
            ]
        );

        if (!auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
        }

        Owner::create($data);

        return redirect()->route('owners.index')
            ->with('success', 'Owner created successfully.');
    }

    public function edit(Owner $owner)
    {
        $this->authorize('update', $owner);

        $users = User::all();

        return view('owners.edit', compact('owner', 'users'));
    }

    public function update(Request $request, Owner $owner)
    {
        $this->authorize('update', $owner);

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
                'user_id' => [
                    'nullable',
                    'exists:users,id',
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

                'user_id.exists' => 'Selected insurance agent does not exist.',
            ]
        );

        if (!auth()->user()->isAdmin()) {
            unset($data['user_id']);
        }

        $owner->update($data);

        return redirect()->route('owners.index')
            ->with('success', 'Owner updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $this->authorize('delete', $owner);

        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted successfully.');
    }
}